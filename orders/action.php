<?php

use classes\db\DBPostgres;

if (array_key_exists('action', $_GET) && array_key_exists('id', $_GET)) {
    if ($_GET["action"] == 'approve') {
        DBPostgres::getOrderHandler()->accept(PROFILE_ID, $_GET['id']);
    } elseif ($_GET["action"] == 'reject') {
        DBPostgres::getOrderHandler()->reject(PROFILE_ID, $_GET['id']);

        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($_GET['date']);
            foreach ($table as &$item) {
                $item = $item['id'];
            }
            $index = array_search(PROFILE_ID, $table);
            if ($index == count($table) - 1) {
                DBPostgres::getOrderHandler()->cancel($_GET['id']);
            } else {
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval($table[$index + 1]), $_GET['id']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } elseif ($_GET["action"] == 'finish') {
        DBPostgres::getOrderHandler()->finish(PROFILE_ID, $_GET['id']);
    }
}
