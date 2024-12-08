<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
use classes\db\DBPostgres;
if (!DBPostgres::isConnected()) {
    DBPostgres::connect();
}
