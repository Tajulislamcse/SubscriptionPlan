<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_at',
        'end_at',
        'status', // active, expired, trial
        'gateway_response', // JSON storing Stripe info
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'gateway_response' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
