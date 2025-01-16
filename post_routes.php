<?php

get_route('/logout', function () {
    setcookie("USER_ID", '', time() - 3600, HOST);
    setcookie("ROLE", '', time() - 3600, HOST);
    setcookie("PROFILE_ID", '', time() - 3600, HOST);
    header('Location: https://se.ifmo.ru/~s338923/isbd/login/');
});

post_route('/controller', 'controller/backend.php');

post_route('/profile/selection', 'profile/selection/index.php');

post_route('/profile/create', 'profile/create.php');

post_route('/profile', 'profile/index.php');

post_route('/technique', 'technique/index.php');