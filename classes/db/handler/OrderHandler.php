<?php
namespace classes\db\handler;
interface OrderHandler
{
    function getCurrentByClient(int $clientId): array;
    function getHistoryByClient(int $clientId): array;
}