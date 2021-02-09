<?php

namespace App\Helpers;

use Auth;

class DateTimeHelper {
    
    const dateformat = 'Y-m-d';
    
    const datetimeformat = 'Y-m-d H:i';
    
    const fulldatetimeformat = 'Y-m-d\TH:i:sP';
    
    const timeformat = 'H:i';
    
    public static function getUserTimezone() {
        $timezone = Auth::user()->timezone;
        if(!$timezone) {
            $timezone = 'Asia/Kolkata';
        }
        
        return new \DateTimeZone($timezone);
    }

    /**
     * 
     * @param array $timeArray
     */
    public static function createMeetingTime($timeArray, $convertToUtc = true) {
        $date = $timeArray['date']; 
        $fullDate = $date." ".$timeArray['time'].$timeArray['format'];
        
        if($convertToUtc) {
            return self::getUtcTime($fullDate);
        }
        
        $dateTime = new \DateTime($fullDate);
        
        return $dateTime->format(static::datetimeformat);
        
        
    }
    
    /**
     * 
     * @param type $duration
     * @return type
     */
    public static function createMeetingDuration($duration) {
        $hr = $duration['hr'];
        $min = $duration['min'];
        $hr = ($hr < 10 && strlen($hr) == 1) ? '0'.$hr : $hr;
        
        return $hr.":".$min;
    }
    
    public static function timeStamp( $date = 'now')
    {
        $datetime = new \DateTime( $date);

        return $datetime->getTimestamp();
    }
    
    /**
     * 
     * @param string $date
     * @param string $duration
     */
    public static function addDurationInTime($date, $duration) {
        $time = new \DateTime($date);
        $durationInMinutes = self::hourMinute2Minutes($duration);
        $time->add(new \DateInterval('PT' . $durationInMinutes . 'M'));

        return $time->format(static::datetimeformat);
    }
    
    public static function hourMinute2Minutes($strHourMinute) {
        $from = date('Y-m-d 00:00:00');
        $to = date('Y-m-d '.$strHourMinute.':00');
        $diff = strtotime($to) - strtotime($from);
        $minutes = $diff / 60;
        
        return (int) $minutes;
    }

    public static function getUtcTime($date = 'now', $format = 'Y-m-d\TH:i:sP') {
        $dateTime = new \DateTime($date, self::getUserTimezone());
        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        
        return $dateTime->format($format);
    }
}