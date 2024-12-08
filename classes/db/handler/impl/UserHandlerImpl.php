<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\entity\Entity;
use classes\db\handler\UserHandler;

class UserHandlerImpl implements UserHandler
{

    function add(Entity $object): int
    {
        // TODO: Implement add() method.
    }

    function update(int $id, Entity $object): bool
    {
        // TODO: Implement update() method.
    }

    function getById(int $id): Entity
    {
        // TODO: Implement getById() method.
    }

    function get(int $offset = 0, int $limit = 10): array
    {
        // TODO: Implement get() method.
    }

    function authorize(string $login, string $password): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT check_password(:login, :password)');

        // bind value to the :id parameter
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':password', $password);
        // execute the statement
        $stmt->execute();

        // return the result set as an object
        $obj = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($obj['check_password']) {
            $obj['check_password'] = trim($obj['check_password'], '()');
            $ar = explode(",",$obj['check_password']);
            return $ar[0];
        } else {
            return 0;
        }
    }
}