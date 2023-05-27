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

    public function getUser(string $username): array
    {
        
        return $this->model->getUser($username);

    }
  

   
}
