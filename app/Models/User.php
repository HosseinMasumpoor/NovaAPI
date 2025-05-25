<?php

namespace App\Models;

use App\Core\Auth\Interfaces\AuthenticatableInterface;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableInterface {
    protected $table = 'users';
    protected $guarded = [];
}
