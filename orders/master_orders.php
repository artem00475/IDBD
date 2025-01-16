<?php

use classes\db\DBPostgres;

if (array_key_exists('action', $_GET) && array_key_exists('id', $_GET)) {
    if ($_GET["action"] == 'approve') {
        DBPostgres::getOrderHandler()->accept(PROFILE_ID, $_GET['id']);
    } elseif ($_GET["action"] == 'reject') {
        DBPostgres::getOrderHandler()->reject(PROFILE_ID, $_GET['id']);

        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($_GET['date']);
            foreach ($table as &$item) {
                $item = $item['id'];
            }
            $index = array_search(PROFILE_ID, $table);
            if ($index == count($table) - 1) {
                DBPostgres::getOrderHandler()->cancel($_GET['id']);
            } else {
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval($table[$index + 1]), $_GET['id']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } elseif ($_GET["action"] == 'finish') {
        DBPostgres::getOrderHandler()->finish(PROFILE_ID, $_GET['id']);
    }
}
?>

<h1>Заказы мастера</h1>
<h2>Новые заказы</h2>
<div class="list">
    <?php
    $newOrders = DBPostgres::getOrderHandler()->getNewByMaster(PROFILE_ID);
    foreach ($newOrders as $order) { ?>
        <div class="item">
            <div class='order'>
                <a href="<?= HOST ?>/orders/?action=approve&id=<?= $order->getId(); ?>">Принять заказ</a>
                <a href="<?= HOST ?>/orders/?action=reject&id=<?= $order->getId(); ?>&date=<?= $order->getDate(); ?>">Отклонить
                    заказ</a>
                <p>Заказ №<?= $order->getId(); ?> Статус - <?= $order->getStatus(); ?></p>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
<h2>Активные заказы</h2>
<div class="list">
    <?php
    $currentOrders = DBPostgres::getOrderHandler()->getCurrentByMaster(PROFILE_ID);
    foreach ($currentOrders as $order) { ?>
        <div class="item">
            <div class='order'>
                <a href="<?= HOST ?>/orders/?action=finish&id=<?= $order->getId(); ?>">Завершить заказ</a>
                <p>Заказ №<?= $order->getId(); ?> Статус - <?= $order->getStatus(); ?></p>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
<h2>История заказов</h2>
<div class="list">
    <?php
    $oldOrders = DBPostgres::getOrderHandler()->getHistoryByMaster(PROFILE_ID);
    foreach ($oldOrders as $order) { ?>
        <div class="item">
            <div class='order'>
                <p>Заказ №<?= $order->getId(); ?> Статус - <?= $order->getStatus(); ?></p>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
