<?php

namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\entity\ClientProfile;
use classes\db\handler\ClientProfileHandler;
use PDO;

class ClientProfileHandlerImpl implements ClientProfileHandler
{

    function authorize(int $userId): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT check_client(:user)');
        $stmt->bindValue(':user', $userId);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['check_client']) {
            $obj['check_client'] = trim($obj['check_client'], '()');
            $ar = explode(",",$obj['check_client']);
            return $ar[0];
        } else {
            return 0;
        }
    }

    function add(ClientProfile $client): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT create_client(:userId, :address, :photo)');
        $stmt->bindValue(':userId', $client->getUserId());
        $stmt->bindValue(':address', $client->getAddress());
        $stmt->bindValue(':photo', $client->getPhoto());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['create_client']) {
            $obj['create_client'] = trim($obj['create_client'], '()');
            $ar = explode(",",$obj['create_client']);
            return $ar[0];
        } else {
            return 0;
        }
    }

    function getById(int $id): ClientProfile|null
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_client(:id)');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($obj['get_client']) {
            $obj['get_client'] = trim($obj['get_client'], '()');
            $ar = explode(",",$obj['get_client']);
            $client = new ClientProfile();
            $client->setUserId($ar[1]);
            $client->setAddress($ar[2]);
            $client->setPhoto($ar[3]);
            return $client;
        } else {
            return null;
        }
    }

    function update(int $id, ClientProfile $clientProfile): bool
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT update_client(:id, :userId, :address, :photo)');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':userId', $clientProfile->getUserId());
        $stmt->bindValue(':address', $clientProfile->getAddress());
        $stmt->bindValue(':photo', $clientProfile->getPhoto());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['update_client']) {
            $obj['update_client'] = trim($obj['update_client'], '()');
            $ar = explode(",",$obj['update_client']);
            return $ar[0];
        } else {
            return 0;
        }
    }
}