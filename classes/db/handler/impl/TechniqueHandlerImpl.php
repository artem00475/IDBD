<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\handler\TechniqueHandler;

class TechniqueHandlerImpl implements TechniqueHandler
{

    function getAll(): array
    {
        $arTechnique = [];
        $stmt = DBPostgres::getConnection()->query('SELECT get_technique()');
        while ($obj = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_technique'] = trim($obj['get_technique'], '()');
            $ar = explode(",", $obj['get_technique']);
            $arTechnique[$ar[0]] = $ar[1];
        }
        return $arTechnique;
    }
}