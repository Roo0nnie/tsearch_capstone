<?php

namespace App\Observers;

use App\Models\Imrad;
use App\Models\Preference;

class ImradObserver
{
    /**
     * Handle the Imrad "created" event.
     */
    public function created(Imrad $imrad): void
    {
        //
    }

    /**
     * Handle the Imrad "updated" event.
     */
    public function updated(Imrad $imrad): void
    {
        //
    }

    /**
     * Handle the Imrad "deleted" event.
     */
    public function deleted(Imrad $imrad): void
{
    $imrads = Imrad::all();
    $user_preferences = Preference::all();

    $authorList = [];
    $adviserList = [];
    $departmentList = [];
    foreach ($imrads as $imrad) {

        $authors = array_map('trim', explode(',', $imrad->author));
        foreach ($authors as $author) {
            if ($author !== '' && !in_array($author, $authorList)) {
                $authorList[] = $author;
            }
        }

        $advisers = array_map('trim', explode(',', $imrad->adviser));
        foreach ($advisers as $adviser) {
            if ($adviser !== '' && !in_array($adviser, $adviserList)) {
                $adviserList[] = $adviser;
            }
        }

        $department = trim($imrad->department);
        if ($department !== '' && !in_array($department, $departmentList)) {
            $departmentList[] = $department;
        }
    }

    foreach ($user_preferences as $user_preference) {

        $preference_authorList = [];
        $preference_adviserList = [];
        $preference_departmentList = [];


        $preference_authors = array_map('trim', explode(',', $user_preference->authors));
        foreach ($preference_authors as $preference_author) {
            if ($preference_author !== '' && in_array($preference_author, $authorList)) {
                $preference_authorList[] = $preference_author;
            }
        }

        $preference_advisers = array_map('trim', explode(',', $user_preference->advisers));
        foreach ($preference_advisers as $preference_adviser) {
            if ($preference_adviser !== '' && in_array($preference_adviser, $adviserList)) {
                $preference_adviserList[] = $preference_adviser;
            }
        }

        $preference_departments = array_map('trim', explode(',', $user_preference->departments));
        foreach ($preference_departments as $preference_department) {
            if ($preference_department !== '' && in_array($preference_department, $departmentList)) {
                $preference_departmentList[] = $preference_department;
            }
        }

        $user_preference->update([
            'authors' => implode(',', $preference_authorList),
            'advisers' => implode(',', $preference_adviserList),
            'departments' => implode(',', $preference_departmentList),
        ]);
    }


}


    /**
     * Handle the Imrad "restored" event.
     */
    public function restored(Imrad $imrad): void
    {
        //
    }

    /**
     * Handle the Imrad "force deleted" event.
     */
    public function forceDeleted(Imrad $imrad): void
    {
        //
    }
}
