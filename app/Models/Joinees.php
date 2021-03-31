<?php

namespace App\Models;

use App\Models\BaseModel;

class Joinees extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_address',
        'meeting_id'
    ];
}
