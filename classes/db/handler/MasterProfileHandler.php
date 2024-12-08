<?php
namespace classes\db\handler;
interface MasterProfileHandler extends Handler
{
    function authorize(int $userId): int;
}