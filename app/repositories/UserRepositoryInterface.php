<?php


namespace repositories;

interface UserRepositoryInterface
{
    public function getUserById(int $id): array;
   // public function insert(array $data): void;
}
