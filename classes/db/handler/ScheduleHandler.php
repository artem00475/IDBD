<?php

namespace classes\db\handler;

interface ScheduleHandler
{
    function getByMaster(int $masterId): array;

    function updateByMaster(int $masterId, array $schedule): array;
}