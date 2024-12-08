<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\entity\Entity;
use classes\db\handler\MasterProfileHandler;

class MasterProfileHandlerImpl implements MasterProfileHandler
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

    function authorize(int $userId): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT check_master(:user)');

        // bind value to the :id parameter
        $stmt->bindValue(':user', $userId);
        // execute the statement
        $stmt->execute();

        // return the result set as an object
        $obj = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($obj['check_master']) {
            $obj['check_master'] = trim($obj['check_master'], '()');
            $ar = explode(",",$obj['check_master']);
            return $ar[0];
        } else {
            return 0;
        }
    }
}