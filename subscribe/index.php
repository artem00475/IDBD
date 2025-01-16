<?php

use classes\db\DBPostgres;

?>

<h1>Подписка</h1>
<div class="btn_block">
    <button class="btn" onclick="showForm(this)">Оформить новую подписку</button>
    <form action="<?= HOST ?>/controller/" id='form' class="subscribe-form" method="post">
        <input type="text" hidden name="action_type" value="new_subscribe">
        <div class="element">
            <label for="start_date">Дата начала подписки</label>
            <input type="date" name='start_date' required>
        </div>
        <div class="element">
            <label for="finish_date">Дата окончания подписки</label>
            <input type="date" name='finish_date' required>
        </div>
        <div class="element">
            <label for="technique">Выберите план</label>
            <select name="technique" required>
                <?php
                $plans = DBPostgres::getPlanHandler()->getAll();
                foreach ($plans as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>
        <input type="submit" class='btn' value="Сохранить">
    </form>
</div>
<div class="list">
    <?php
    $subscriptions = DBPostgres::getSubscriberHandler()->getByClient(PROFILE_ID);
    foreach ($subscriptions as $subscription) { ?>
        <div class="item">
            <div class='info'>
                <p>Тип: <?= $subscription->getPlan(); ?></p>
                <p>Дата оформления: <?= $subscription->getStartDate(); ?></p>
                <p>Дата окончания: <?= $subscription->getFinishDate(); ?></p>
                <p>Цена: <?= $subscription->getCost(); ?>р</p>
            </div>
        </div>
    <?php } ?>
</div>
