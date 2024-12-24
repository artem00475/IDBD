<?php
namespace classes\db\handler;
use classes\db\entity\Subscription;

interface SubscriberHandler
{
    function getByClient(int $clientId): array;

    function add(Subscription $subscription): void;
}