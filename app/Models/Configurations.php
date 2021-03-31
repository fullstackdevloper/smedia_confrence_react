<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configurations extends Model {

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value'
    ];

    public static function updateConfiguration($key, $value) {
        $configValue = self::getByKey($key, true);
        if ($configValue->count()) {
            //update
            Configurations::where('key', $key)->update(['value' => $value]);
        } else {
            // insert new
            Configurations::create(['key' => $key, 'value' => $value]);
        }
    }

    public static function getByKey($key, $checkExistance = false) {
        $row = Configurations::where('key', $key);
        if($checkExistance) {
            return $row;
        }
        if ($row->count()) {
            return $row->first()->value;
        } else {
            return false;
        }
    }

    public static function getAll() {
        $configs = array();
        $configs_db = Configurations::all();
        foreach ($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        return (object) $configs;
    }
    
    public static function getStripePublicKey() {
        $stripeMode = self::getByKey('stripe_mode');
        if($stripeMode == 'live') {
            return self::getByKey('stripe_publish_key');
        }else {
            return self::getByKey('stripe_test_publish_key');
        }
    }
    
    public static function getPaymentCurriencies() {
        return [
            'inr' => 'INR',
            'usd' => 'USD',
        ];
    }
}
