<?php

namespace App\Observers;

use App\Models\GuestAccount;
use App\Models\LogHistory;
use App\Models\Rating;
use App\Models\ImradMetric;

class GuestAccountObserver
{
    /**
     * Handle the GuestAccount "created" event.
     */
    public function created(GuestAccount $guestAccount): void
    {
        //
    }

    /**
     * Handle the GuestAccount "updated" event.
     */
    public function updated(GuestAccount $guestAccount): void
    {
        if ($guestAccount->isDirty('name')) {

            LogHistory::where('user_code', $guestAccount->user_code)
                ->update(['name' => $guestAccount->name]);
        }
    }

    /**
     * Handle the GuestAccount "deleted" event.
     */
    public function deleted(GuestAccount $guestAccount): void
    {
        $user_code = $guestAccount->user_code;

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
     * Handle the GuestAccount "restored" event.
     */
    public function restored(GuestAccount $guestAccount): void
    {
        //
    }

    /**
     * Handle the GuestAccount "force deleted" event.
     */
    public function forceDeleted(GuestAccount $guestAccount): void
    {
        //
    }
}
