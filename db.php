<?php
use classes\db\DBPostgres;
if (!DBPostgres::isConnected()) {
    DBPostgres::connect();
}
