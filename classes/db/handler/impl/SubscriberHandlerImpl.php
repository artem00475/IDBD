<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\entity\Subscription;
use classes\db\handler\SubscriberHandler;

class SubscriberHandlerImpl implements SubscriberHandler
{
    function getByClient(int $clientId): array
    {
        $arSub = [];
        $req = DBPostgres::getConnection()->prepare('SELECT findall_subscribes(:user_id)');
        $req->bindValue(':user_id', $clientId);
        $req->execute();
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['findall_subscribes'] = trim($obj['findall_subscribes'], '()');
            $ar = explode(",", $obj['findall_subscribes']);
            $sub = new Subscription();
            $sub->setPlan($ar[0]);
            $sub->setStartDate(date('d.m.Y', strtotime($ar[1])));
            $sub->setFinishDate(date('d.m.Y', strtotime($ar[2])));
            $sub->setCost($ar[3]);
            $arSub[] = $sub;
        }
        return $arSub;
    }

    function add(Subscription $subscription): void
    {
        $req = DBPostgres::getConnection()->prepare('SELECT subscribe_client_plan(:client_id,:plan_id,:start_date,:finish_date)');
        $req->bindValue(':client_id', $subscription->getClient());
        $req->bindValue(':start_date', $subscription->getStartDate());
        $req->bindValue(':finish_date', $subscription->getFinishDate());
        $req->bindValue(':plan_id', $subscription->getPlan());
        $req->execute();
    }
}