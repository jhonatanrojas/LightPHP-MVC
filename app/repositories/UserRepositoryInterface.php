<?php


namespace repositories;

interface UserRepositoryInterface
{
    public function getUser(string $user_name): array;
   // public function insert(array $data): void;
}
