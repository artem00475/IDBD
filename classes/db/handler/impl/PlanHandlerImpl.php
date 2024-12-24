<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\handler\PlanHandler;

class PlanHandlerImpl implements PlanHandler
{

    function getAll(): array
    {
        $arPlan = [];
        $stmt = DBPostgres::getConnection()->query('SELECT get_subscribe_plans()');
        while ($obj = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_subscribe_plans'] = trim($obj['get_subscribe_plans'], '()');
            $ar = explode(",", $obj['get_subscribe_plans']);
            $arPlan[$ar[0]] = $ar[1];
        }
        return $arPlan;
    }
}