<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'duration_days', 'data_limit', 'is_active'];
}
