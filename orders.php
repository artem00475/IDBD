<?php

use classes\db\DBPostgres;

include_once "header.php";
if (array_key_exists('action', $_GET) && array_key_exists('id', $_GET)) {
    if ($_GET["action"] == 'approve') {
        DBPostgres::getOrderHandler()->accept($_COOKIE['USER_ID'], $_GET['id']);
    } elseif ($_GET["action"] == 'reject') {
        DBPostgres::getOrderHandler()->reject($_COOKIE['USER_ID'], $_GET['id']);

        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($_GET['date']);
            foreach ($table as &$item) {
                $item = $item['id'];
            }
            $index = array_search($_COOKIE['USER_ID'], $table);
            if ($index == count($table)-1) {
                DBPostgres::getOrderHandler()->cancel($_GET['id']);
            } else {
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval($table[$index+1]), $_GET['id']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } elseif ($_GET["action"] == 'finish') {
        DBPostgres::getOrderHandler()->finish($_COOKIE['USER_ID'], $_GET['id']);
    }
}
?>
<div class='main'>
    <h1>Заказы мастера</h1>
    <h2>Новые заказы</h2>
    <div class="list">
        <?php
        $newOrders = DBPostgres::getOrderHandler()->getNewByMaster($_COOKIE['USER_ID']);
        foreach ($newOrders as $order) {?>
            <div class="item">
                <div class='order'>
                    <a href="/~s338923/isbd/orders.php?action=approve&id=<?= $order->getId();?>">Принять заказ</a>
                    <a href="/~s338923/isbd/orders.php?action=reject&id=<?= $order->getId();?>&date=<?= $order->getDate();?>">Отклонить заказ</a>
                    <p>Заказ №<?= $order->getId();?> Статус - <?= $order->getStatus();?></p>
                    <p>Тип техники: <?= $order->getTechnique();?></p>
                    <p>Дата ремонта: <?= $order->getDate();?></p>
                    <p>Клиент: <?= $order->getClient();?></p>
                    <p>Цена: <?= $order->getCost();?>р</p>
                    <p>Комментарий: <?= $order->getContent();?></p>
                </div>
            </div>
        <?php }?>
    </div>
    <h2>Активные заказы</h2>
    <div class="list">
        <?php
        $currentOrders = DBPostgres::getOrderHandler()->getCurrentByMaster($_COOKIE['USER_ID']);
        foreach ($currentOrders as $order) {?>
            <div class="item">
                <div class='order'>
                    <a href="/~s338923/isbd/orders.php?action=finish&id=<?=$order->getId();?>">Завершить заказ</a>
                    <p>Заказ №<?= $order->getId();?> Статус - <?= $order->getStatus();?></p>
                    <p>Тип техники: <?= $order->getTechnique();?></p>
                    <p>Дата ремонта: <?= $order->getDate();?></p>
                    <p>Клиент: <?= $order->getClient();?></p>
                    <p>Цена: <?= $order->getCost();?>р</p>
                    <p>Комментарий: <?= $order->getContent();?></p>
                </div>
            </div>
        <?php }?>
    </div>
    <h2>История заказов</h2>
    <div class="list">
        <?php
        $oldOrders = DBPostgres::getOrderHandler()->getHistoryByMaster($_COOKIE['USER_ID']);
        foreach ($oldOrders as $order) {?>
            <div class="item">
                <div class='order'>
                    <p>Заказ №<?= $order->getId();?> Статус - <?= $order->getStatus();?></p>
                    <p>Тип техники: <?= $order->getTechnique();?></p>
                    <p>Дата ремонта: <?= $order->getDate();?></p>
                    <p>Клиент: <?= $order->getClient();?></p>
                    <p>Цена: <?= $order->getCost();?>р</p>
                    <p>Комментарий: <?= $order->getContent();?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php include_once "footer.php";?>
