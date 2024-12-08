<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\handler\OwnerHandler;
use PDO;

class OwnerHandlerImpl implements OwnerHandler
{

    function getByClient(int $clientId): array
    {
        $arOwners = [];
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_owners(:user)');
        $stmt->bindValue(':user', $clientId);
        $stmt->execute();
        while ($obj = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj['get_owners'] = trim($obj['get_owners'], '()');
            $ar = explode(",", $obj['get_owners']);
            $arOwners[$ar[0]] = $ar[2];
        }
        return $arOwners;
    }
}