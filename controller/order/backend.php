<?php

use classes\db\DBPostgres;
use classes\db\entity\Feedback;
use classes\db\entity\Order;

switch ($_POST["action_type"]) {
    case 'create_order':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];
        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($date);
            if (count($table) > 0) {
                $order = new Order();
                $order->setClient(PROFILE_ID);
                $order->setTechnique($technique);
                $order->setContent($comment);
                $order->setCost(1000);
                $order->setDate($date);
                $orderId = DBPostgres::getOrderHandler()->add($order);
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval(current($table)['id']), $orderId);
            } else { ?>
                <script>alert('Нет свободных мастеров на эту дату')</script>
            <?php }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'create_order_master':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $masterId = $_POST["masterId"];
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];

        try {
            $order = new Order();
            $order->setClient(PROFILE_ID);
            $order->setTechnique($technique);
            $order->setContent($comment);
            $order->setCost(1000);
            $order->setDate($date);
            $orderId = DBPostgres::getOrderHandler()->addWithMaster($order, $masterId);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'rate_order':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $order = $_POST["order_id"];
        $comment = $_POST["comment"];
        $rating = $_POST["rating"];
        try {
            $feedback = new Feedback();
            $feedback->setOrderId($order);
            $feedback->setClientId(PROFILE_ID);
            $feedback->setContent($comment);
            $feedback->setRating($rating);
            DBPostgres::getFeedbackHandler()->add($feedback);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
}