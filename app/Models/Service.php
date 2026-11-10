<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'customer_name',
        'customer_phone',
        'device_type',
        'device_brand',
        'problem_description',
        'status',
    ];
}