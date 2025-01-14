<?php

use classes\db\DBPostgres;

include_once "header.php";
?>

    <div class='main'>
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
                            <img src="/~s338923/isbd/img/worker-<?= $id ?>.jpg" alt="master_photo" class="avatar">
                        </div>
                        <p><?= $worker['NAME']; ?></p>
                        <p>Рейтинг: <?= $worker['RATE']; ?></p>
                        <p>Стаж(год): <?= $worker['EXPERIENCE']; ?></p>
                        <p>Квалификация: <?= $worker['QUALIFICATION']; ?></p>
                        <p>Расписание: <?= $schedule; ?></p>
                        <a href="index.php?masterId=<?= $id ?>">Создать заказ</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php include_once "footer.php"; ?>