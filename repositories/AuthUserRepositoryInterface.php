<?php


namespace repositories;

interface AuthUserRepositoryInterface
{
    public function getUser(int $id_user): array;
    public function insert(array $data): void;
}
