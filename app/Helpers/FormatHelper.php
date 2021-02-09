<?php

namespace App\Helpers;

use App\Models\User;

class FormatHelper {

    public function phoneNumber() {
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
        return "(" . substr($data, 0, 3) . ") " . substr($data, 3, 3) . " " . substr($data, 6);
    }
    
    public static function meetingId($meetingId) {
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
        return substr($meetingId, 0, 3) . " " . substr($meetingId, 3, 3) . " " . substr($meetingId, 6);
    }
    
    /**
     * generate meeting id for user
     * 
     * @return string meeting id
     */
    public static function generateMettingId() {
        $number = mt_rand(1000000000, 9999999999); // better than rand()
        // call the same function if the barcode exists already
        if (self::meetingIdExists($number)) {
            return self::generateMettingId();
        }

        // otherwise, it's valid and can be used
        return $number;
    }
    
    /**
     * check if meeting id already exist
     * @param string $number
     * @return bool
     */
    private static function meetingIdExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return User::wherePersonalMeetId($number)->exists();
    }
}
