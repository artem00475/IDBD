<?php
namespace classes\db\handler;
interface SubscriberHandler
{
    function getByClient(int $clientId): array;
}