<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\handler\QAHandler;

class QAHandlerImpl implements QAHandler
{

    function getAll(): array
    {
        $arQuestion = [];
        $req = DBPostgres::getConnection()->query('SELECT findall_faq()');
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['findall_faq'] = trim($obj['findall_faq'], '()');
            $ar = explode('","', $obj['findall_faq']);
            $arQuestion[] = [
                'Q' => $ar[0],
                'A' => $ar[1]
            ];
        }
        return $arQuestion;
    }
}