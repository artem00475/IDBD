<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="<?= HOST ?>/css/auth.css">
</head>
<body>
<div class="registration-cssave">
    <?php

    use classes\db\DBPostgres;
    use classes\db\entity\User;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username'] && $_POST['password']) {
        include_once "db.php";
        $user = new User();
        $user->setLogin($_POST['username']);
        $user->setPassword($_POST['password']);
        $user->setName($_POST['name']);
        $user->setSurname($_POST['surname']);
        $user->setEmail($_POST['email']);
        $user->setPhone($_POST['phone']);

        $userId = DBPostgres::getUserHandler()->add($user);
        if ($userId) {
            setcookie('USER_ID', $userId, 0, HOST);
            header('Location: https://se.ifmo.ru/~s338923/isbd/');
        } else {
            echo 'Пользователь уже существует';
        }
    }
    ?>
    <form method="post">
        <h3 class="text-center">Форма регистрации</h3>
        <div class="form-group">
            <input class="form-control item" type="text" name="username" maxlength="20" minlength="4"
                   pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Логин" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="password" name="password" minlength="8" maxlength="50" id="password"
                   placeholder="Пароль" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="name" maxlength="20" minlength="1"
                   pattern="^[a-zA-Z0-9_.-]*$" id="name" placeholder="Имя" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="surname" maxlength="20" id="surname"
                   placeholder="Фамилия" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="email" maxlength="30" minlength="1"
                   pattern="^[a-zA-Z0-9_.-]*$" id="email" placeholder="Почта" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="phone" maxlength="11" id="phone" placeholder="Телефон"
                   required>
        </div>
        <div class="form-group btns">
            <button class="btn btn-primary btn-block create-account" type="submit">Зарегистрироваться</button>
            <a href="<?= HOST ?>/login/" class="btn btn-primary btn-block create-new-account">Уже есть аккаунт</a>
        </div>
    </form>
</div>
</body>
</html>