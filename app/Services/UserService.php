<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\JWTAuth\JWTAuthService;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function __construct(protected UserRepository $repository){

    }

    public function updateProfile(string $id, array $data): bool
    {
        if(isset($data['image'])){
            $fileName = hashFileName($data['image']);
            storage()->put($fileName, $data['image']);
            $data['image'] = $fileName;
        }

        return $this->repository->updateItem($id, $data);
    }

}
