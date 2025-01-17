<?php

get_route('/logout', function () {
    setcookie("USER_ID", '', time() - 3600, HOST);
    setcookie("ROLE", '', time() - 3600, HOST);
    setcookie("PROFILE_ID", '', time() - 3600, HOST);
    header('Location: https://se.ifmo.ru/~s338923/isbd/login/');
});

post_route('/controller/order', 'controller/order/backend.php');

post_route('/controller/profile', 'controller/profile/backend.php');

post_route('/controller/service', 'controller/service/backend.php');