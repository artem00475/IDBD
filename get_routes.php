<?php

get_route('/profile/selection', 'profile/selection/index.php');

get_route('/profile/create', 'profile/create.php');

get_route('/profile', 'profile/index.php');

get_route('/orders/$orderId/rating', 'orders/rating/index.php');
get_route('/orders/', 'orders/index.php');
get_route('/orders', 'orders/index.php');
get_route('', 'orders/index.php');

get_route('/qa', 'qa/index.php');

get_route('/subscribe', 'subscribe/index.php');

get_route('/workers', 'workers/index.php');

get_route('/schedule', 'schedule/index.php');
get_route('/schedule/change', 'schedule/change.php');

get_route('/technique', 'technique/index.php');

any_route('/404','404.php');
