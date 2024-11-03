<?php

namespace App\Observers;

use App\Models\Faculty;
use App\Models\LogHistory;
use App\Models\Rating;
use App\Models\ImradMetric;

class FacultyObserver
{
    /**
     * Handle the Faculty "created" event.
     */
    public function created(Faculty $faculty): void
    {
        //
    }

    /**
     * Handle the Faculty "updated" event.
     */
    public function updated(Faculty $faculty): void
    {
        if ($faculty->isDirty('name')) {

            LogHistory::where('user_code', $faculty->user_code)
                ->update(['name' => $faculty->name]);
        }
    }

    /**
     * Handle the Faculty "deleted" event.
     */
    public function deleted(Faculty $faculty): void
    {
        $user_code = $faculty->user_code;

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
     * Handle the Faculty "restored" event.
     */
    public function restored(Faculty $faculty): void
    {
        //
    }

    /**
     * Handle the Faculty "force deleted" event.
     */
    public function forceDeleted(Faculty $faculty): void
    {
        //
    }
}
