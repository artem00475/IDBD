<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    include $class_name . '.php';
});
use classes\db\DBPostgres;
if (!DBPostgres::isConnected()) {
    DBPostgres::connect();
}
