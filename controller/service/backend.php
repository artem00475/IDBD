<?php

use classes\db\DBPostgres;
use classes\db\entity\Subscription;
use classes\db\entity\SupportRequest;
use classes\db\entity\Technique;

switch ($_POST["action_type"]) {
    case 'add_technique':
        header('Location: https://se.ifmo.ru/~s338923/isbd/technique/');
        $date = $_POST["date"];
        $technique = $_POST["technique"];
        try {
            $tech = new Technique();
            $tech->setClientId(PROFILE_ID);
            $tech->setDate($date);
            $tech->setTechnique($technique);
            DBPostgres::getOwnerHandler()->add($tech);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'new_subscribe':
        header('Location: https://se.ifmo.ru/~s338923/isbd/subscribe/');
        $start_date = $_POST["start_date"];
        $finish_date = $_POST["finish_date"];
        $plan_id = $_POST["technique"];
        try {
            $sub = new Subscription();
            $sub->setClient(PROFILE_ID);
            $sub->setPlan($plan_id);
            $sub->setStartDate($start_date);
            $sub->setFinishDate($finish_date);
            DBPostgres::getSubscriberHandler()->add($sub);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'qa':
        header('Location: https://se.ifmo.ru/~s338923/isbd/qa/');
        $theme = $_POST["theme"];
        $comment = $_POST["comment"];
        try {
            $request = new SupportRequest();
            $request->setClientId(PROFILE_ID);
            $request->setTheme($theme);
            $request->setContent($theme);
            DBPostgres::getSupportRequestHandler()->add($request);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'schedule':
        header('Location: https://se.ifmo.ru/~s338923/isbd/schedule/');
        $days = $_POST["days"];
        try {
            DBPostgres::getScheduleHandler()->updateByMaster(PROFILE_ID, $days);
        } catch (Error $e) {
            echo $e->getMessage();
        }
        break;
}
