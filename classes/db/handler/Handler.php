<?php

namespace classes\db\handler;

use classes\db\entity\Entity;

interface Handler
{
    function add(Entity $object): int;
    function update(int $id, Entity $object): bool;
    function getById(int $id): Entity;
    function get(int $offset = 0, int $limit = 10): array;
}