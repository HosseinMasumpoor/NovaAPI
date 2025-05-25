<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JWTBlacklist extends Model{
    protected $table = 'jwt_blacklist';
    protected $guarded = [];
    public $timestamps = false;
}
