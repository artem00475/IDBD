<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\entity\SupportRequest;
use classes\db\handler\SupportRequestHandler;

class SupportRequestHandlerImpl implements SupportRequestHandler
{

    function add(SupportRequest $supportRequest): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT leave_question(:client_id,:theme,:comment)');
        $req->bindValue(':client_id', $supportRequest->getClientId());
        $req->bindValue(':theme', $supportRequest->getTheme());
        $req->bindValue(':comment', $supportRequest->getContent());
        $req->execute();
    }
}