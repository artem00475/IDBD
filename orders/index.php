<?php

if (ROLE == 'Master') {
    include 'master_orders.php';
} else {
    include 'client_orders.php';
}