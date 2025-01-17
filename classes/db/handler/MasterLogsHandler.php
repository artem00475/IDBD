<?php

namespace classes\db\handler;
interface MasterLogsHandler
{
    function addNewOrder(int $masterId, int $orderId): void;
}