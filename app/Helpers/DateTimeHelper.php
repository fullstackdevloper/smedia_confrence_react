<?php

namespace App\Helpers;

use Auth;
use App\Models\UserMeta;
use App\Models\Configurations;
use App\Providers\meetingServiceProvider;

class DateTimeHelper {
    
    const fulldatetimeformat = 'Y-m-d\TH:i:sP';
    
    /**
     *  get user timezone 
     * @param string $string if true only timezone string will be returned
     * @return \DateTimeZone|string
     */
    public static function getUserTimezone($string = false) {
        $timezone = null;
        if(Auth::check()) {
            $timezone = UserMeta::getUserMeta(Auth::user()->id, 'timezone');
        }
        if(!$timezone) {
            $timezone = 'Asia/Kolkata';
        }
        if($string) {
            return $timezone;
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
        
        return $dateTime->format(static::fulldatetimeformat);
        
        
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
    
    /**
     * 
     * @param Time $duration
     * @param string $index i.e hr or min
     * @return Integer
     */
    public static function getMeetingDuration($duration, $index = 'hr') {
        $durationArray = explode(':', $duration);
        if(count($durationArray) == 2) {
            if($index == 'hr') {
                return $durationArray['0'];
            }else if($index == 'min') {
                return $durationArray['1'];
            }
        }
    }
    /**
     * calculate meeting duration
     * @param \App\Helpers\App\Models\Meetings $meeting
     */
    public static function displayMeetingDuration(\App\Models\Meetings $meeting) {
        if(meetingServiceProvider::init()->isPersonal($meeting)) {
            return false;
        }
        
        if($meeting->is_ended) {
            $startTime = $meeting->original_start_time;
            $endTime = $meeting->original_end_time;
            
        }else {
            $startTime = $meeting->start_time;
            $endTime = self::addDurationInTime($startTime, $meeting->meeting_duration);
        }
        $origin = new \DateTime($startTime);
        $target = new \DateTime($endTime);
        $interval = $origin->diff($target);
        //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
        $min=$interval->format('%i');
        $sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');
        
        if($interval->format('%i%h%d%m%y')=="00000") {
            //echo $interval->format('%i%h%d%m%y')."<br>";
            return $sec." Seconds";
        } else if($interval->format('%h%d%m%y')=="0000"){
            return $min." Minutes";
        } else if($interval->format('%d%m%y')=="000"){
            return $hour." Hours";
        } else if($interval->format('%m%y')=="00"){
            return $day." Days";
        } else if($interval->format('%y')=="0"){
            return $mon." Months";
        } else{
            return $year." Years";
        }    
    }
    
    /**
     * convert date to timestamp
     * @param type $date
     * @return string Timestamp
     */
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
        if(!$date) {
            return false;
        }
        $time = new \DateTime($date);
        $durationInMinutes = self::hourMinute2Minutes($duration);
        $time->add(new \DateInterval('PT' . $durationInMinutes . 'M'));

        return $time->format(static::fulldatetimeformat);
    }
    
    /**
     * convert hours to minute
     * @param string $strHourMinute
     * @return string hours to minute
     */
    public static function hourMinute2Minutes($strHourMinute) {
        $from = date('Y-m-d 00:00:00');
        $to = date('Y-m-d '.$strHourMinute.':00');
        $diff = strtotime($to) - strtotime($from);
        $minutes = $diff / 60;
        
        return (int) $minutes;
    }
    
    /**
     * get time in UTC format
     * @param string $date
     * @param string $format
     * @return string Date in UTC
     */
    public static function getUtcTime($date = 'now', $format = 'Y-m-d\TH:i:sP') {
        $dateTime = new \DateTime($date, self::getUserTimezone());
        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        
        return $dateTime->format($format);
    }
    
    /**
     * get the full date to display according to user timezone
     * 
     * @param string $date date to display in UTC format
     * @param string $format date format
     * @return string formated full date
     */
    public static function displayFullDate($date = 'now', $format = null) {
        $dateTime = new \DateTime($date, new \DateTimeZone('UTC'));
        $dateTime->setTimezone(self::getUserTimezone());
        if($format == null) {
            $format = self::getFullDateFormat();
        }
        return $dateTime->format($format);
    }
    
    /**
     * get the date to display according to user timezone
     * 
     * @param string $date date to display in UTC format
     * @param string $format date format
     * @return string formated date
     */
    public static function displayDate($date = 'now', $format = null) {
        $dateTime = new \DateTime($date, new \DateTimeZone('UTC'));
        $dateTime->setTimezone(self::getUserTimezone());
        if($format == null) {
            $format = self::getDateFormat();
        }
        
        return $dateTime->format($format);
    }
    
    /**
     * get the Time to display according to user timezone
     * 
     * @param string $date date to display in UTC format
     * @param string $format date format
     * @return string formated Time
     */
    public static function displayTime($date = 'now', $format = null) {
        $dateTime = new \DateTime($date, new \DateTimeZone('UTC'));
        $dateTime->setTimezone(self::getUserTimezone());
        if($format == null) {
            $format = self::getTimeFormat();
        }
        
        return $dateTime->format($format);
    }
    
    /**
     * get date formate
     * @return string
     */
    private static function getDateFormat() {
        $dateformat = Configurations::getByKey('date_format');
        
        return $dateformat ? $dateformat : 'd m, Y';
    }
    
    /**
     * get full date format
     * 
     * @return string
     */
    private static function getFullDateFormat() {
        $fulldateformat = Configurations::getByKey('date_time_format');
        
        return $fulldateformat? $fulldateformat : 'd m, Y H:i T';
    }
    
    /**
     * get time format
     * @return string Time format
     */
    private static function getTimeFormat() {
        $timeformat = Configurations::getByKey('time_format');
        
        return $timeformat ? $timeformat : 'H:i';
    }
    
    /**
     * get all timezones
     * 
     * @return string Timezoneoptions
     */
    public static function getAllTimeZones(){

        //print_r(\DateTimeZone::listIdentifiers());
        $selectOptions = "";
        $userTimezone = self::getUserTimezone(true);
        foreach(\DateTimeZone::listIdentifiers() as  $zoneLabel)
        {
            //$selectOptions.="<option>This is test</option>";
            $currentTimeInZone = new \DateTime("now", new \DateTimeZone($zoneLabel));
            $currentTimeDiff = $currentTimeInZone->format('P');
            $selected = $userTimezone == $zoneLabel ? "selected" : "not";
            $selectOptions .= "<option {$selected} value=\"$zoneLabel\">(GMT $currentTimeDiff) $zoneLabel</option>";
        }

        echo $selectOptions;
    }
}