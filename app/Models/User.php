<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use BinaryCabin\LaravelUUID\Traits\HasUUID;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUUID;
    
    protected $uuidFieldName = 'guid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'personal_meet_id',
        'phone',
        'timezone',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function isLastAdmin(User $user) {
        if($user->role == 'admin') {
            
        }
    }

    public function UserMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'id');
    }
}
