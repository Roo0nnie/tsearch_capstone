<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Rating;
use App\Models\ImradMetric;
use App\Models\LogHistory;


class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user)
    {
        if ($user->isDirty('name')) {

            LogHistory::where('user_code', $user->user_code)
                ->update(['name' => $user->name]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user_code = $user->user_code;

        $userRating = Rating::where('user_code', $user_code)->get();
        foreach ($userRating as $rating) {

            $imrad_id = $rating->metric_id;

            $rating->delete();

            $averageRating = Rating::where('metric_id', $imrad_id)->avg('rating');

            $averageRating = $averageRating ?? 0;

            ImradMetric::where('imradID', $imrad_id)->update(['rates' => $averageRating]);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
