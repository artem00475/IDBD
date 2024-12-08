<?php

namespace classes\db;

use classes\Entities\ClientProfile;
use classes\Entities\MasterProfile;
use classes\Entities\User;

interface DBInterface
{
    function connect();
    function addUser(User $user): int;

    function authorizeUser(String $login, String $password): bool;

    function getUserProfiles(int $userId): array;

    function addMasterProfile(MasterProfile $profile): int;

    function addClientProfile(ClientProfile $profile): int;

    function updateClientProfile(ClientProfile $profile): bool;

    function updateMasterProfile(MasterProfile $profile): bool;
    function updateUser(int $userId, User $user): bool;




}