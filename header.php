<?php
include_once "db.php";
if (!$_COOKIE["USER_ID"]) {
    header('Location: https://se.ifmo.ru/~s338923/isbd/auth.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
 
<head>
    <meta charset="UTF-8">
    <title>Сервис ремонта</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/page.css">
    <link rel="stylesheet" href="css/modal.css">
    <!-- <link rel="stylesheet" href="css/auth.css"> -->
</head>
<body>
<div class="header">
    <a class="logo">Сервис ремонта</a>
    <div class="header-right">
        <?php
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
        ?>
        <a href="role.php" <?php if($url == "/~s338923/isbd/role.php"):?>class="active"<?php endif?>>Роль</a>
        <?php if (isset($_COOKIE["ROLE"])):?>
        <style>
            .main{
                display:flex;
            }
        </style>
        <?php if ($_COOKIE["ROLE"]=="Client"):?>
        <a href="index.php" <?php if($url == "/~s338923/isbd/index.php"):?>class="active"<?php endif?>>Заказы</a>
        <a href="qa.php" <?php if($url == "/~s338923/isbd/qa.php"):?>class="active"<?php endif?>>Вопросы</a>
        <a href="subscribe.php" <?php if($url == "/~s338923/isbd/subscribe.php"):?>class="active"<?php endif?>>Подписка</a>
        <a href="workers.php" <?php if($url == "/~s338923/isbd/workers.php"):?>class="active"<?php endif?>>Мастера</a>
        <a href="add.php" <?php if($url == "/~s338923/isbd/add.php"):?>class="active"<?php endif?>>Приборы</a>
        <?php elseif ($_COOKIE["ROLE"]=="Master"):?>
        <a href="profile.php" <?php if($url == "/~s338923/isbd/profile.php"):?>class="active"<?php endif?>>Профиль мастера</a>
        <a href="orders.php" <?php if($url == "/~s338923/isbd/orders.php"):?>class="active"<?php endif?>>Заказы мастера</a>
        <?php endif?>
        <?php endif?>
        <a href="my_profile.php">Ваш профиль</a>
        <a href="auth.php?exit=y">Выход</a>
    </div>
</div>


