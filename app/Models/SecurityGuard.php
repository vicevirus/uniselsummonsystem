<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SecurityGuard extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'securityId';
    protected $fillable = ['securityName', 'guard_username', 'guard_password'];

    public function getAuthPassword()
    {
        return $this->guard_password; 
    }

  
}
