<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use BinaryCabin\LaravelUUID\Traits\HasUUID;

class Meetings extends Model
{
    use HasFactory, HasUUID;
    
    protected $uuidFieldName = 'guid';
    
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
        'start_time',
        'meeting_duration',
        'participant_count'
    ];
}
