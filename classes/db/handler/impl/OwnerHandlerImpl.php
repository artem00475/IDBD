<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\entity\Technique;
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
            $technique = new Technique();
            $technique->setTechnique($ar[2]);
            $technique->setDate($ar[1]);
            $arOwners[$ar[0]] = $technique;
        }
        return $arOwners;
    }

    function add(Technique $technique): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT add_technique(:client_id,:date,:technique)');
        $req->bindValue(':client_id', $technique->getClientId());
        $req->bindValue(':date', $technique->getDate());
        $req->bindValue(':technique', $technique->getTechnique());
        $req->execute();
    }
}