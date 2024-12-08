<?php
namespace classes\db\handler;
interface OwnerHandler
{
    function getByClient(int $clientId): array;
}