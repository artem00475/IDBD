<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\handler\MasterLogsHandler;

class MasterLogsHandlerImpl implements MasterLogsHandler
{

    function addNewOrder(int $masterId, int $orderId): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT add_order(:order_id, :master_id)');
        $req->bindValue(':master_id', $masterId);
        $req->bindValue(':order_id', $orderId);
        $req->execute();
    }
}