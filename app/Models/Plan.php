<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $fillable = ['name','image','description', 'price', 'duration_days', 'data_limit', 'is_active'];
    public const FILE_STORE_PATH    = 'plans';

}
