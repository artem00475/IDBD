<?php

use classes\db\DBPostgres;

?>

<h1>Заказы</h1>
<div class="btn_block">
    <button class="btn" onclick="showForm(this)"
            <?php if (array_key_exists('masterId', $_GET)): ?>style="display: none;"<?php endif ?>>Создать заказ
    </button>
    <?php
    $owners = DBPostgres::getOwnerHandler()->getByClient(PROFILE_ID);
    ?>
    <form method='POST' class='save-order-form' id='form' action="<?= HOST ?>/controller/"
          <?php if (array_key_exists('masterId', $_GET)): ?>style="display: flex;"<?php endif ?>>
        <?php if (array_key_exists('masterId', $_GET)) { ?>
            <input type="text" hidden name="action_type" value="create_order_master">
            <input type="text" hidden name="masterId" value="<?= $_GET['masterId'] ?>">
        <?php } else { ?>
            <input type="text" hidden name="action_type" value="create_order">
        <?php } ?>
        <div class="element">
            <label for="date">Дата, когда приедет мастер</label>
            <input type="date" name='date' required>
        </div>
        <div class="element">
            <label for="comment">Опишите проблему</label>
            <input type="text" name='comment' required>
        </div>
        <div class="element">
            <label for="technique">Выберите прибор</label>
            <select name="technique" required>
                <?php foreach ($owners as $id => $value) { ?>
                    <option value="<?= $id ?>"><?= $value->getTechnique() ?></option>
                <?php } ?>
            </select>
        </div>
        <input type="submit" class='btn' value="Сохранить">
    </form>
</div>
<h2>Активные заказы</h2>
<div class="list">
    <?php
    $currentOrders = DBPostgres::getOrderHandler()->getCurrentByClient(PROFILE_ID);
    foreach ($currentOrders as $order) { ?>
        <div class="item">
            <div class='info'>
                <p>Заказ №<?= $order->getId(); ?> Статус - <?= $order->getStatus(); ?></p>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Мастер: <?= $order->getMaster(); ?></p>
                <p>Оплата: <?= $order->getPayment(); ?></p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
<h2>История заказов</h2>
<div class="list">
    <?php
    $oldOrders = DBPostgres::getOrderHandler()->getHistoryByClient(PROFILE_ID);
    foreach ($oldOrders as $order) { ?>
        <div class="item">
            <div class='info'>
                <?php if ($order->getStatus() == 'Завершен') { ?>
                    <a href="<?= HOST ?>/orders/<?= $order->getId() ?>/rating/">Оценить заказ</a>
                <?php } ?>
                <p>Заказ №<?= $order->getId(); ?> Статус - <?= $order->getStatus(); ?></p>
                <p>Тип техники: <?= $order->getTechnique(); ?></p>
                <p>Дата ремонта: <?= $order->getDate(); ?></p>
                <p>Мастер: <?= $order->getMaster(); ?></p>
                <p>Оплата: <?= $order->getPayment(); ?></p>
                <p>Комментарий: <?= $order->getContent(); ?></p>
            </div>
        </div>
    <?php } ?>
</div>

