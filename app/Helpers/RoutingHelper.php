<?php

namespace App\Helpers;

use App\Models\Meetings;
use App\Helpers\EncryptionHelper;

class RoutingHelper { 
    
    /**
     * get meeting start url
     * @param \App\Models\Meetings\Meetings $meeting
     * @return string Meeting start Url
     */
    public static function getMeetingStartLink(Meetings $meeting) {
        $meetingLink = printf(url('join/%s?pass=%s'), $meeting->meeting_id, EncryptionHelper::encode($meeting->password));
        
        return $meetingLink;
    }
}