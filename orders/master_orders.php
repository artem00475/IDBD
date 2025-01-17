<?php

use classes\db\DBPostgres;

?>

<h1>Заказы мастера</h1>
<h2>Новые заказы</h2>
<div class="list">
    <?php
    $newOrders = DBPostgres::getOrderHandler()->getNewByMaster(PROFILE_ID);
    foreach ($newOrders as $order) {
        $status = $order->getStatus();
        ?>
        <div class="item">
            <div class='order'>
                <div class="order-title">
                    <p><strong>Заказ №<?= $order->getId(); ?></strong></p>
                    <span class="status-badge <?= getStatusStyle($status) ?>"><?= $status ?></span>
                </div>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
                <a href="<?= HOST ?>/orders/?action=approve&id=<?= $order->getId(); ?>">Принять заказ</a>
                <a class="reject"
                   href="<?= HOST ?>/orders/?action=reject&id=<?= $order->getId(); ?>&date=<?= $order->getDate(); ?>">Отклонить
                    заказ</a>
            </div>
        </div>
    <?php } ?>
</div>
<h2>Активные заказы</h2>
<div class="list">
    <?php
    $currentOrders = DBPostgres::getOrderHandler()->getCurrentByMaster(PROFILE_ID);
    foreach ($currentOrders as $order) {
        $status = $order->getStatus();
        ?>
        <div class="item">
            <div class='order'>
                <div class="order-title">
                    <p><strong>Заказ №<?= $order->getId(); ?></strong></p>
                    <span class="status-badge <?= getStatusStyle($status) ?>"><?= $status ?></span>
                </div>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
                <a href="<?= HOST ?>/orders/?action=finish&id=<?= $order->getId(); ?>">Завершить заказ</a>
            </div>
        </div>
    <?php } ?>
</div>
<h2>История заказов</h2>
<div class="list">
    <?php
    $oldOrders = DBPostgres::getOrderHandler()->getHistoryByMaster(PROFILE_ID);
    foreach ($oldOrders as $order) {
        $status = $order->getStatus();
        ?>
        <div class="item">
            <div class='order'>
                <div class="order-title">
                    <p><strong>Заказ №<?= $order->getId(); ?></strong></p>
                    <span class="status-badge <?= getStatusStyle($status) ?>"><?= $status ?></span>
                </div>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Клиент: <?= $order->getClient(); ?></p>
                <p>Цена: <?= $order->getCost(); ?>р</p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
