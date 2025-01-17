<?php

namespace classes\db\handler;

use classes\db\entity\Technique;

interface OwnerHandler
{
    function getByClient(int $clientId): array;

    function add(Technique $technique): void;
}