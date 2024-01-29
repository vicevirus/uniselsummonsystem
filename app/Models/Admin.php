<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'adminId';
    protected $fillable = ['adminName', 'admin_username', 'admin_password'];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }
}
