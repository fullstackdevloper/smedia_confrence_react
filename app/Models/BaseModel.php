<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    use HasFactory, HasUUID;
    
    protected $rules = array();

    protected $errors;
    
    protected $uuidFieldName = 'guid';
    
    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules);

        // check for failure
        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}