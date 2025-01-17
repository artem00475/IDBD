<?php

function getStatusStyle(string $status): string
{
    return match ($status) {
        'Отменен' => 'status-canceled',
        'Поиск' => 'status-pending',
        'Завершен' => 'status-done',
        default => '',
    };
}

if (ROLE == 'Master') {
    include 'action.php';
    include 'master_orders.php';
} else {
    include 'client_orders.php';
}