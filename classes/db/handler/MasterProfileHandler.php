<?php
namespace classes\db\handler;
use classes\db\entity\MasterProfile;

interface MasterProfileHandler
{
    function authorize(int $userId): int;
    function add(MasterProfile $masterProfile): int;
    function getById(int $id): MasterProfile|null;
    function update(int $id, MasterProfile $masterProfile): bool;

    function getAll(): array;
}