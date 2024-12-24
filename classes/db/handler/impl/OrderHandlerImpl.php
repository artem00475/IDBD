<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\entity\Order;
use classes\db\handler\OrderHandler;
use PDO;

class OrderHandlerImpl implements OrderHandler
{
    function getCurrentByClient(int $clientId): array
    {
        $arOrder = [];
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_client_current_orders(:user)');
        $stmt->bindValue(':user', $_COOKIE['USER_ID']);
        $stmt->execute();
        while ($obj = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj['get_client_current_orders'] = trim($obj['get_client_current_orders'], '()');
            $ar = explode(",", $obj['get_client_current_orders']);
            $order = new Order();
            $order->setId($ar[0]);
            $order->setContent($ar[1]);
            $order->setPayment($ar[2]);
            $order->setDate(date('d.m.Y', strtotime($ar[3])));
            $order->setStatus($ar[4]);
            $order->setMaster($ar[5]);
            $order->setTechnique($ar[6]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }

    function getHistoryByClient(int $clientId): array
    {
        $arOrder = [];
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_client_history_orders(:user)');
        $stmt->bindValue(':user', $_COOKIE['USER_ID']);
        $stmt->execute();
        while ($obj = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj['get_client_history_orders'] = trim($obj['get_client_history_orders'], '()');
            $ar = explode(",", $obj['get_client_history_orders']);
            $order = new Order();
            $order->setId($ar[0]);
            $order->setContent($ar[1]);
            $order->setPayment($ar[2]);
            $order->setDate(date('d.m.Y', strtotime($ar[3])));
            $order->setStatus($ar[4]);
            $order->setMaster($ar[5]);
            $order->setTechnique($ar[6]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }

    function getNewByMaster(int $masterId): array
    {
        $arOrder = [];
        $req = DBPostgres::getConnection()->prepare('SELECT get_master_new_orders(:user_id)');
        $req->bindValue(':user_id', $masterId);
        $req->execute();
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_master_new_orders'] = trim($obj['get_master_new_orders'], '()');
            $ar = explode(",", $obj['get_master_new_orders']);
            $order = new Order();
            $order->setId($ar[0]);
            $order->setContent($ar[1]);
            $order->setCost($ar[2]);
            $order->setDate(date('d.m.Y', strtotime($ar[3])));
            $order->setStatus($ar[4]);
            $order->setClient($ar[6]);
            $order->setTechnique($ar[5]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }

    function getCurrentByMaster(int $masterId): array
    {
        $arOrder = [];
        $req = DBPostgres::getConnection()->prepare('SELECT get_master_current_orders(:user_id)');
        $req->bindValue(':user_id', $_COOKIE['USER_ID']);
        $req->execute();
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_master_current_orders'] = trim($obj['get_master_current_orders'], '()');
            $ar = explode(",", $obj['get_master_current_orders']);
            $order = new Order();
            $order->setId($ar[0]);
            $order->setContent($ar[1]);
            $order->setCost($ar[2]);
            $order->setDate(date('d.m.Y', strtotime($ar[3])));
            $order->setStatus($ar[4]);
            $order->setClient($ar[6]);
            $order->setTechnique($ar[5]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }

    function getHistoryByMaster(int $masterId): array
    {
        $arOrder = [];
        $req = DBPostgres::getConnection()->prepare('SELECT get_master_order_history(:user_id)');
        $req->bindValue(':user_id', $_COOKIE['USER_ID']);
        $req->execute();
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_master_order_history'] = trim($obj['get_master_order_history'], '()');
            $ar = explode(",", $obj['get_master_order_history']);
            $order = new Order();
            $order->setId($ar[0]);
            $order->setContent($ar[1]);
            $order->setCost($ar[2]);
            $order->setDate(date('d.m.Y', strtotime($ar[3])));
            $order->setStatus($ar[4]);
            $order->setClient($ar[6]);
            $order->setTechnique($ar[5]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }

    function accept(int $masterId, int $orderId): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT accept_order(:order_id,:master_id)');
        $req->bindValue(':master_id', $masterId);
        $req->bindValue(':order_id', $orderId);
        $req->execute();
    }

    function reject(int $masterId, int $orderId): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT reject_order(:order_id,:master_id)');
        $req->bindValue(':master_id', $masterId);
        $req->bindValue(':order_id', $orderId);
        $req->execute();
    }

    function cancel(int $orderId): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT cancel_order(:order_id)');
        $req->bindValue(':order_id', $orderId);
        $req->execute();
    }

    function finish(int $masterId, int $orderId): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT finish_order(:order_id,:master_id)');
        $req->bindValue(':master_id', $masterId);
        $req->bindValue(':order_id', $orderId);
        $req->execute();
    }

    function add(Order $order): int
    {
        $req = DBPostgres::getConnection()->prepare('SELECT create_order(:client_id,:technique_id,:order_content,:order_cost,:date)');
        $req->bindValue(':client_id', $order->getClient());
        $req->bindValue(':technique_id', $order->getTechnique());
        $req->bindValue(':order_content', $order->getContent());
        $req->bindValue(':order_cost', $order->getCost());
        $req->bindValue(':date', $order->getDate());
        $req->execute();

        $req = DBPostgres::getConnection()->prepare('select currval(:name)');
        $req->bindValue(':name','s338923.orders_id_seq');
        $req->execute();
        $obj = $req->fetch(\PDO::FETCH_ASSOC);
        return $obj['currval'];
    }

    function addWithMaster(Order $order, int $masterId): int
    {
        $req = DBPostgres::getConnection()->prepare('SELECT create_order_with_master(:client_id,:technique_id,:order_content,:order_cost,:date,:masterId)');
        $req->bindValue(':client_id', $order->getClient());
        $req->bindValue(':technique_id', $order->getTechnique());
        $req->bindValue(':order_content', $order->getContent());
        $req->bindValue(':order_cost', $order->getCost());
        $req->bindValue(':date', $order->getDate());
        $req->bindValue(':masterId',$masterId);
        $req->execute();

        $req = DBPostgres::getConnection()->prepare('select currval(:name)');
        $req->bindValue(':name','s338923.orders_id_seq');
        $req->execute();
        $obj = $req->fetch(\PDO::FETCH_ASSOC);
        return $obj['currval'];
    }
}