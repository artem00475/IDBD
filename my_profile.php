<?php

use classes\db\DBPostgres;

include_once "header.php";

$role = $_COOKIE["ROLE"];
$userId = $_COOKIE["USER_ID"] ?? 0;
$profileId = $_COOKIE["PROFILE_ID"] ?? 0; ?>
    <div class='main'>
        <h1>Ваши данные</h1>
        <?php
        $user = DBPostgres::getUserHandler()->getById($userId);
        $login = $user->getLogin();
        $name = $user->getName();
        $surname = $user->getSurname();
        $email = $user->getEmail();
        $phone = $user->getPhone();
        ?>
        <div class="btn_block">
            <form action="backend.php" id='form' class="profile-form" method="post">
                <input type="text" hidden name="action_type" value="update_user">
                <div class="element">
                    <label for="login">Логин</label>
                    <input class="form-control item" type="text" name="login" placeholder="Логин" id="login"
                           value="<?php echo $login; ?>" required maxlength="20">
                </div>
                <div class="element">
                    <label for="name">Имя</label>
                    <input class="form-control item" type="text" name="name" placeholder="Имя" id="name"
                           value="<?php echo $name; ?>" required maxlength="20">
                </div>
                <div class="element">
                    <label for="surname">Фамилия</label>
                    <input class="form-control item" type="text" name="surname" placeholder="Фамилия" id="surname"
                           value="<?php echo $surname; ?>" required maxlength="20">
                </div>
                <div class="element">
                    <label for="email">Email</label>
                    <input class="form-control item" type="email" name="email" placeholder="Ваш email" id="email"
                           value="<?php echo $email; ?>" required>
                </div>
                <div class="element">
                    <label for="phone">Телефон</label>
                    <input class="form-control item" type="tel" name="phone" placeholder="Телефон" id="phone"
                           value="<?php echo $phone; ?>" required>
                </div>
                <div class="element">
                    <label for="password">Пароль</label>
                    <input class="form-control item" type="password" name="password" placeholder="Пароль" id="password"
                           minlength="8">
                </div>
                <input type="submit" class='btn' value="Сохранить">
            </form>
        </div>
        <?php if ($role == "Master"):
            $master = DBPostgres::getMasterProfileHandler()->getById($profileId);
            $experience = $master->getExperience();
            $qualification = $master->getQualification();
            $photo = '/~s338923/isbd' . $master->getPhoto();
            ?>
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
                               id="qualification" placeholder="Квалификация" value="<?php echo $qualification; ?>"
                               required>
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
        <?php elseif ($role == "Client"):
            $client = DBPostgres::getClientProfileHandler()->getById($profileId);
            $address = $client->getAddress();
            $photo = '/~s338923/isbd' . $client->getPhoto();
            ?>
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
        <?php endif ?>
    </div>
<?php include_once "footer.php"; ?>