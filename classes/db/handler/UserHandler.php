<?php
namespace classes\db\handler;
interface UserHandler extends Handler
{
    function authorize(string $login, string $password): int;
}