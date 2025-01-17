<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Сервис ремонта</title>
</head>
<style>
    <?php include 'css/header.css'; ?>
    <?php include 'css/page.css'; ?>
    <?php include 'css/modal.css'; ?>
</style>
<script>
    function showForm(btn) {
        btn.style.display = 'none';
        document.getElementById('form').style.display = 'flex';
    }
</script>
<body>
<div class="header">
    <a class="logo" href="<?= HOST ?>/">Сервис ремонта</a>
    <div class="header-right">
        <?php
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
        ?>
        <a href="<?= HOST ?>/profile/selection"
           <?php if ($url == HOST . "/profile/selection/"): ?>class="active"<?php endif ?>>Выбор профиля</a>
        <?php if (ROLE && PROFILE_ID): ?>
            <?php if (ROLE == "Client"): ?>
                <a href="<?= HOST ?>/orders"
                   <?php if ($url == HOST . "/orders/" || $url == HOST . "/"): ?>class="active"<?php endif ?>>Заказы</a>
                <a href="<?= HOST ?>/qa" <?php if ($url == HOST . "/qa/"): ?>class="active"<?php endif ?>>Вопросы</a>
                <a href="<?= HOST ?>/subscribe"
                   <?php if ($url == HOST . "/subscribe/"): ?>class="active"<?php endif ?>>Подписка</a>
                <a href="<?= HOST ?>/workers" <?php if ($url == HOST . "/workers/"): ?>class="active"<?php endif ?>>Мастера</a>
                <a href="<?= HOST ?>/technique"
                   <?php if ($url == HOST . "/technique/"): ?>class="active"<?php endif ?>>Приборы</a>
            <?php elseif (ROLE == "Master"): ?>
                <a href="<?= HOST ?>/orders"
                   <?php if ($url == HOST . "/orders/" || $url == HOST . "/"): ?>class="active"<?php endif ?>>Заказы
                    мастера</a>
                <a href="<?= HOST ?>/schedule" <?php if ($url == HOST . "/schedule/"): ?>class="active"<?php endif ?>>Расписание</a>
            <?php endif ?>
            <a href="<?= HOST ?>/profile" <?php if ($url == HOST . "/profile/"): ?>class="active"<?php endif ?>>Ваш
                профиль</a>
        <?php endif ?>
        <a href="<?= HOST ?>/logout/">Выход</a>
    </div>
</div>
<div class="main">


