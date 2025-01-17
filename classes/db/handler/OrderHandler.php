<?php

namespace classes\db\handler;

use classes\db\entity\Order;

interface OrderHandler
{
    function getCurrentByClient(int $clientId): array;

    function getHistoryByClient(int $clientId): array;

    function getNewByMaster(int $masterId): array;

    function getCurrentByMaster(int $masterId): array;

    function getHistoryByMaster(int $masterId): array;

    function accept(int $masterId, int $orderId): void;

    function reject(int $masterId, int $orderId): void;

    function cancel(int $orderId): void;

    function finish(int $masterId, int $orderId): void;

    function add(Order $order): int;

    function addWithMaster(Order $order, int $masterId): int;

}