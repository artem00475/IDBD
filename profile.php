<?php use classes\db\DBPostgres;

include_once "header.php";?>
<div class='main'>
<h1>Профиль на доске мастеров</h1>
<?php if (array_key_exists('change', $_GET) && $_GET['change'] == 'y'):?>
    <form method='POST' class='schedule-form' id='form' style="display: flex;" action="backend.php">
    <input type="text" hidden name="action_type" value="schedule">
            <div class="element">
                <label for="days[]">Выберите дни</label>
                <select  name="days[]" required multiple="multiple">
                    <option value="1">Понедельник</option>
                    <option value="2">Вторник</option>
                    <option value="3">Среда</option>
                    <option value="4">Четверг</option>
                    <option value="5">Пятница</option>
                    <option value="6">Суббота</option>
                    <option value="7">Воскресенье</option>
                </select>
            </div>
            <input type="submit" class='btn' value="Сохранить">
        </form>
<?php else:?>
    <div class="list">
        <?php
            $master = DBPostgres::getMasterProfileHandler()->getById($_COOKIE['PROFILE_ID']);
            $user = DBPostgres::getUserHandler()->getById($master->getUserId());
            $schedule = DBPostgres::getScheduleHandler()->getByMaster($_COOKIE['PROFILE_ID']);
            $schedule = implode(',', $schedule);
        ?>
        <div class="item">
            <div class='photo'>
                <img src="/~s338923/isbd/<?=$master->getPhoto()?>" alt="master_photo" class="avatar">
            </div>
            <div class='info'>
                <p><?=$user->getName()?> <?=$user->getSurname()?></p>
                <p>Рейтинг: <?=$master->getRating()?></p>
                <p>Стаж: <?=$master->getExperience()?></p>
                <p>Расписание: <?=$schedule?></p>
                <a href="profile.php?change=y">Изменить расписание</a>
            </div>
        </div>
    </div>
<?php endif?>
</div>
<?php include_once "footer.php";?>