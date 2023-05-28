<?php

namespace repositories;

use models\User;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUserById(int $id): array
    {
        
        return  $this->model->where('id', $id)->first();

    }
  

   
}
