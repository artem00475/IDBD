<?php

use classes\db\DBPostgres;

?>

<h1>Мастера</h1>
<div class="list">
    <?php
    $workers = DBPostgres::getMasterProfileHandler()->getAll();
    foreach ($workers as $id => $worker) {
        $schedule = DBPostgres::getScheduleHandler()->getByMaster($id);
        $schedule = implode(',', $schedule);
        ?>
        <div class="item">
            <div class='info'>
                <div class='photo'>
                    <img src="<?= HOST . $worker['PHOTO']; ?>" alt="master_photo" class="avatar">
                </div>
                <p><?= $worker['NAME']; ?></p>
                <p>Рейтинг: <?= $worker['RATE']; ?></p>
                <p>Стаж(год): <?= $worker['EXPERIENCE']; ?></p>
                <p>Квалификация: <?= $worker['QUALIFICATION']; ?></p>
                <p>Расписание: <?= $schedule; ?></p>
                <a href="<?= HOST ?>/orders?masterId=<?= $id ?>">Создать заказ</a>
            </div>
        </div>
    <?php } ?>
</div>

