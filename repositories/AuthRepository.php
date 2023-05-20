<?php

namespace repositories\socialMedia;

use models\SocialAccessTokenModel;

class AuthRepository implements SocialAccessTokenRepositoryInterface
{
    private $model;

    public function __construct(SocialAccessTokenModel $model)
    {
        $this->model = $model;
    }

    public function getAccess(int $id_user): array
    {
        return $this->model->getAccess($id_user);
    }

    public function insert(array $data): void
    {
    
        if (!isset($data['id_user'], $data['id_user_red'], $data['red_social'], $data['user_name'], $data['img_perfil'], $data['access_token'])) {
            throw new \InvalidArgumentException('Datos inválidos');
        }
        $this->model->insert($data);
    }
}
