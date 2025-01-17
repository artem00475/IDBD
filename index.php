<?php
const HOST = '/~s338923/isbd';
define("USER_ID", $_COOKIE["USER_ID"]);
define("ROLE", $_COOKIE["ROLE"] ?? '');
define("PROFILE_ID", $_COOKIE["PROFILE_ID"] ?? 0);

include_once 'router.php';

if (!USER_ID) {
    get_route('/login', 'login/index.php');
    post_route('/login', 'login/index.php');
    get_route('/signup', 'login/signup.php');
    post_route('/signup', 'login/signup.php');
    any_route('/404', 'login/404.php');
} elseif (
    (!ROLE || !PROFILE_ID)
    && $_SERVER["REQUEST_URI"] !== HOST . '/profile/selection/'
    && $_SERVER["REQUEST_URI"] !== HOST . '/profile/create/'
) {
    header('Location: https://se.ifmo.ru/~s338923/isbd/profile/selection/');
}

include_once "db.php";

include_once "post_routes.php";

include_once 'header.php';

include_once 'get_routes.php';

include_once 'footer.php';
