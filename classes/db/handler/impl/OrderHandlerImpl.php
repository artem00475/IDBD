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
            $order->setDate($ar[3]);
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
            $order->setDate($ar[3]);
            $order->setStatus($ar[4]);
            $order->setMaster($ar[5]);
            $order->setTechnique($ar[6]);
            $arOrder[$ar[0]] = $order;
        }
        return $arOrder;
    }
}