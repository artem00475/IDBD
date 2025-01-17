<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="<?= HOST ?>/css/auth.css">
</head>
<body>
<div class="registration-cssave">
    <?php

    use classes\db\DBPostgres;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username'] && $_POST['password']) {
        include_once "db.php";
        $pass = true;
        $login = true;
        if ($_POST['username'] == '') {
            echo 'Не заполнено поле логин';
            $login = false;
        }
        if ($_POST['password'] == '') {
            echo 'Не заполнено поле пароль';
            $pass = false;
        }
        if ($login && $pass) {
            if ($userId = DBPostgres::getUserHandler()->authorize($_POST['username'], $_POST['password'])) {
                setcookie("USER_ID", $userId, 0, HOST);
                header('Location: https://se.ifmo.ru/~s338923/isbd/profile/selection');
            } else {
                echo "Неправильный логин или пароль";
            }
        }
    }
    ?>
    <form method="post">
        <h3 class="text-center">Форма входа</h3>
        <div class="form-group">
            <input class="form-control item" type="text" name="username" maxlength="20" minlength="4"
                   pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Логин" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="password" name="password" minlength="4" id="password"
                   placeholder="Пароль" required>
        </div>
        <div class="form-group btns">
            <button class="btn btn-primary btn-block create-account" type="submit">Вход в аккаунт</button>
            <a href="<?= HOST ?>/signup/" class="btn btn-primary btn-block create-new-account">Создать аккаунт</a>
        </div>
    </form>
</div>
</body>
</html>