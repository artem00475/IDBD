<?php

use classes\db\DBPostgres;
use classes\db\entity\Order;
include_once "db.php";
switch ($_POST["action_type"]) {
    case 'create_order':
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];
        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($date);
            if (count($table) > 0) {
                $order = new Order();
                $order->setClient($_COOKIE['USER_ID']);
                $order->setTechnique($technique);
                $order->setContent($comment);
                $order->setCost(1000);
                $order->setDate($date);
                $orderId = DBPostgres::getOrderHandler()->add($order);
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval(current($table)['id']), $orderId);
            } else {?>
                <script>alert('Нет свободных мастеров на эту дату')</script>
            <?php }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/index.php');
        break;

    case 'create_order_master':
        $masterId = $_POST["masterId"];
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];
        
        try {
            $order = new Order();
            $order->setClient($_COOKIE['USER_ID']);
            $order->setTechnique($technique);
            $order->setContent($comment);
            $order->setCost(1000);
            $order->setDate($date);
            $orderId = DBPostgres::getOrderHandler()->addWithMaster($order, $masterId);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/index.php');
        break;

    case 'rate_order':
        $order = $_POST["order_id"];
        $comment = $_POST["comment"];
        $rating = $_POST["rating"];
        try {
            $feedback = new \classes\db\entity\Feedback();
            $feedback->setOrderId($_COOKIE['USER_ID']);
            $feedback->setClientId($order);
            $feedback->setContent($comment);
            $feedback->setRating($rating);
            DBPostgres::getFeedbackHandler()->add($feedback);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/index.php');
        break;

    case 'add_technique':
        $date = $_POST["date"];
        $technique = $_POST["technique"];
        try {
            $tech = new \classes\db\entity\Technique();
            $tech->setClientId($_COOKIE['USER_ID']);
            $tech->setDate($date);
            $tech->setTechnique($technique);
            DBPostgres::getOwnerHandler()->add($tech);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/add.php');
        break;

    case 'new_subscribe':
        $start_date = $_POST["start_date"];
        $finish_date = $_POST["finish_date"];
        $plan_id = $_POST["technique"];
        try {
            $sub = new \classes\db\entity\Subscription();
            $sub->setClient($_COOKIE['USER_ID']);
            $sub->setPlan($plan_id);
            $sub->setStartDate($start_date);
            $sub->setFinishDate($finish_date);
            DBPostgres::getSubscriberHandler()->add($sub);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/subscribe.php');
        break;

    case 'qa':
        $theme = $_POST["theme"];
        $comment = $_POST["comment"];
        try {
            $request = new \classes\db\entity\SupportRequest();
            $request->setClientId($_COOKIE['USER_ID']);
            $request->setTheme($theme);
            $request->setContent($theme);
            DBPostgres::getSupportRequestHandler()->add($request);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/qa.php');
        break;

    case 'schedule':
        $days = $_POST["days"];
        print_r($_POST);
        try {
            DBPostgres::getScheduleHandler()->updateByMaster($_COOKIE['USER_ID'], $days);
        } catch(Error $e) {
            echo $e->getMessage();
        }
        header('Location: https://se.ifmo.ru/~s338923/isbd/profile.php');
        break;
}
?>