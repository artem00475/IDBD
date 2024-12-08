<?php
namespace classes\db\handler;
use classes\db\entity\User;

interface UserHandler
{
    function authorize(string $login, string $password): int;
    function add(User $object): int;
    function update(int $id, User $object): bool;
    function getById(int $id): User|null;
}