<?php

namespace App\Models;

use App\Models\BaseModel;

class Meetings extends BaseModel
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id',
        'title',
        'description',
        'host',
        'password',
        'calendar_event_id',
        'start_time',
        'meeting_duration',
        'participant_count'
    ];
    
    protected $rules = array(
        'title' => ['required', 'max:255'],
        'description' => ['required'],
        'guests' => ['required'],
        'meeting_date.date' => ['required'],
        'meeting_date.time' => ['required'],
        'password' => ['required', 'max:10'],
        'participant_count' => ['required', 'integer', 'max:10', 'min:1']
    );
    
    public function joinee()
    {
        return $this->hasMany('\App\Models\Joinees', 'meeting_id');
    }
}
