<?php

use classes\db\DBPostgres;

?>

<h1>Профиль на доске мастеров</h1>

<div class="list">
    <?php
    $master = DBPostgres::getMasterProfileHandler()->getById(PROFILE_ID);
    $user = DBPostgres::getUserHandler()->getById($master->getUserId());
    $schedule = DBPostgres::getScheduleHandler()->getByMaster(PROFILE_ID);
    $schedule = implode(',', $schedule);
    ?>
    <div class="item">
        <div class='photo'>
            <img src="<?= HOST . $master->getPhoto() ?>" alt="master_photo" class="avatar">
        </div>
        <div class='info'>
            <p><?= $user->getName() ?> <?= $user->getSurname() ?></p>
            <p>Рейтинг: <?= $master->getRating() ?></p>
            <p>Стаж: <?= $master->getExperience() ?></p>
            <p>Расписание: <?= $schedule ?></p>
            <a class="btn change-master-profile" href="<?= HOST ?>/schedule/change">Изменить расписание</a>
        </div>
    </div>
</div>

