<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $casts = [
        // 'dob' => 'datetime:Y-m-d\\TH:i:sO'
        'dob' => 'datetime'
    ];

    protected $fillable = [
        'fullname', 'dob', 'user_id'
    ];
}
