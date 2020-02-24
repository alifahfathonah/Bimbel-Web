<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'username', 'password_enable'];
}
