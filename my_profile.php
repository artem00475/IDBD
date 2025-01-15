<?php

use classes\db\DBPostgres;

include_once "header.php";

$role = $_COOKIE["ROLE"];

$userId = $_COOKIE["PROFILE_ID"] ?? 0;

if ($role == "Master"): ?>
    <?php
    $master = DBPostgres::getMasterProfileHandler()->getById($userId);
    $experience = $master->getExperience();
    $qualification = $master->getQualification();
    $photo = '/~s338923/isbd' . $master->getPhoto();
    ?>

    <!-- обработка формы -->
    <div class='main'>
        <h1>Ваши данные</h1>
        <div class="btn_block">
            <form action="backend.php" id='form' class="profile-form" method="post">
                <input type="text" hidden name="action_type" value="update_master">
                <div class="element">
                    <label for="experience">Опыт</label>
                    <input class="form-control item" type="number" name="experience" maxlength="16"
                           id="experience" placeholder="Ваш опыт" value="<?php echo $experience; ?>" required>
                </div>
                <div class="element">
                    <label for="qualification">Квалификация</label>
                    <input class="form-control item" type="text" name="qualification" maxlength="200" minlength="1"
                           id="qualification" placeholder="Квалификация" value="<?php echo $qualification; ?>" required>
                </div>
                <div class="element">
                    <span>Текущее фото:</span>
                    <img src="<?= $photo; ?>" alt="" class="photo">
                </div>
                <div class="element">
                    <input class="form-control item" type="file" name="photo" id="photo" placeholder="Фото">
                    <label for="photo">Выбрать фото</label>
                </div>
                <input type="submit" class='btn' value="Сохранить">
            </form>
        </div>
    </div>
    </div>

<?php elseif ($role == "Client"): ?>
    <?php
    $client = DBPostgres::getClientProfileHandler()->getById($userId);
    $address = $client->getAddress();
    $photo = '/~s338923/isbd' . $client->getPhoto();
    ?>
    <div class='main'>
        <h1>Ваши данные</h1>
        <div class="btn_block">
            <form action="backend.php" id='form' class="profile-form" method="post">
                <input type="text" hidden name="action_type" value="update_client">
                <div class="element">
                    <label for="address">Адрес</label>
                    <input class="form-control item" type="text" name="address" maxlength="200" minlength="4"
                           id="address" placeholder="Ваш адрес" value="<?php echo $address; ?>" required>
                </div>
                <div class="element">
                    <span>Текущее фото:</span>
                    <img src="<?= $photo; ?>" alt="" class="photo">
                </div>
                <div class="element">
                    <input class="form-control item" type="file" name="photo" id="photo" placeholder="Фото">
                    <label for="photo">Выбрать фото</label>
                </div>
                <input type="submit" class='btn' value="Сохранить">
            </form>
        </div>
    </div>
    </div>
<?php endif ?>
<?php include_once "footer.php"; ?>