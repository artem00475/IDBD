<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\handler\ScheduleHandler;

class ScheduleHandlerImpl implements ScheduleHandler
{

    function getByMaster(int $masterId): array
    {
        $arSchedule = [];
        $req = DBPostgres::getConnection()->prepare('SELECT get_master_schedule(:user_id)');
        $req->bindValue(':user_id', $masterId);
        $req->execute();

        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_master_schedule'] = trim($obj['get_master_schedule'], '()');
            $ar = explode(",", $obj['get_master_schedule']);
            $arSchedule[] = $ar[1];
        }

        return $arSchedule;
    }

    function updateByMaster(int $masterId, array $schedule): array
    {
        $req = DBPostgres::getConnection()->prepare('SELECT delete_schedule(:master_id)');
        $req->bindValue(':master_id', $masterId);
        $req->execute();

        foreach ($schedule as $day) {
            $req = DBPostgres::getConnection()->prepare('SELECT add_day(:master_id, :day_id)');
            $req->bindValue(':master_id', $masterId);
            $req->bindValue(':day_id', $day);
            $req->execute();
        }

        return $schedule;
    }
}