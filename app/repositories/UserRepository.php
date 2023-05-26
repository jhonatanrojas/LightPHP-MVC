<?php

namespace repositories;

use models\userModel;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(userModel $model)
    {
        $this->model = $model;
    }

    public function getUser(string $username): array
    {
        
        return $this->model->getUser($username);

    }
  

   
}
