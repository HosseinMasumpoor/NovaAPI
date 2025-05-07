<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\User;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Cycle\ORM\Select\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    protected string $model = User::class;
}
