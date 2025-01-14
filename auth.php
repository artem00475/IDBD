<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/~s338923/isbd/css/auth.css">
</head>
<body>
<div class="registration-cssave">
    <?php

    use classes\db\DBPostgres;

    if ($_GET['exit'] && $_GET['exit'] == 'y') {
        setcookie("USER_ID", '', time() - 3600);
        setcookie("ROLE", '', time() - 3600);
        setcookie("PROFILE_ID", '', time() - 3600);
    } elseif ($_COOKIE["USER_ID"]) {
        header('Location: https://se.ifmo.ru/~s338923/isbd/role.php');
    }
    if ($_POST['username'] && $_POST['password']) {
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
            include_once "db.php";
            if ($userId = DBPostgres::getUserHandler()->authorize($_POST['username'], $_POST['password'])) {
                setcookie("USER_ID", $userId);
                header('Location: https://se.ifmo.ru/~s338923/isbd/role.php');
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
            <input class="form-control item" type="password" name="password" minlength="1" id="password"
                   placeholder="Пароль" required>
        </div>
        <div class="form-group btns">
            <button class="btn btn-primary btn-block create-account" type="submit">Вход в аккаунт</button>
            <a href="register.php" class="btn btn-primary btn-block create-new-account">Создать аккаунт</a>
        </div>
    </form>
</div>
</body>
</html>