<?php


namespace repositories\socialMedia;

interface SocialAccessTokenRepositoryInterface
{
    public function getAccess(int $id_user): array;
    public function insert(array $data): void;
}
