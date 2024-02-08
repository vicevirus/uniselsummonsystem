<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'matricNumber';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricNumber',
        'icNumber',
        'name',
        'plateNumber',
        'phoneNumber',
        'address',
        'carType',
        'password',
        'QRCodeId'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // 'casts' property should be removed if you're not casting the password or other attributes

    // If you decide to use email verification at some point, uncomment the line below
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
