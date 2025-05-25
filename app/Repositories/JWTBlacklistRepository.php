<?php

namespace App\Repositories;

use App\Models\JWTBlacklist;

class JWTBlacklistRepository extends BaseRepository
{
    protected string $model = JWTBlacklist::class;
}
