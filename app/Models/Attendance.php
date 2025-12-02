<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'date', 'checkin_at', 'checkin_location', 'checkin_photo', 'checkout_at', 'checkout_report'
    ];

    protected $casts = [
        'date' => 'date',
        'checkin_at' => 'datetime',
        'checkout_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
