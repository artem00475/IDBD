<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\entity\Feedback;
use classes\db\handler\FeedbackHandler;

class FeedbackHandlerImpl implements FeedbackHandler
{

    function add(Feedback $feedback): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT leave_feedback(:client_id,:order_id,:order_content,:rating)');
        $req->bindValue(':client_id', $feedback->getClientId());
        $req->bindValue(':order_id', $feedback->getOrderId());
        $req->bindValue(':order_content', $feedback->getContent());
        $req->bindValue(':rating', $feedback->getRating());
        $req->execute();
    }
}