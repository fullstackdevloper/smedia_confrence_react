<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_meta';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'key',
        'value'
    ];
    
    public static function updateUserMeta($userId, $key, $value) {
        if(is_array($value)) {
            $value = serialize($value);
        }
        $meta = self::getUserMeta($userId, $key, false);
        if($meta) {
            $meta->value = $value;
            $meta->save();
            
            return $meta->id; 
        }else {
            UserMeta::create([
                'user_id' =>  $userId,
                'key' => $key,
                'value' => $value
            ]);
        }
    }
    
    public static function getUserMeta($userId, $key = null) {
        $where = [
            ['user_id', '=', $userId]
        ];
        if($key) {
            $where[] = ['key', '=', $key];
        }

        $data = UserMeta::where($where)->get();

        if($key) {
            $data = $data->first();
        }

        if($data) {
            if($key) {
                return $data->value;
            }
            
            return $data->toArray();
        }
        
    }
}
