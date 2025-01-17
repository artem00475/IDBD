<?php

namespace classes\db\handler;

use classes\db\entity\ClientProfile;

interface ClientProfileHandler
{
    function authorize(int $userId): int;

    function add(ClientProfile $client): int;

    function getById(int $id): ClientProfile|null;

    function update(int $id, ClientProfile $clientProfile): bool;
}