<?php

namespace classes\db\handler;
interface ClientProfileHandler extends Handler
{
    function authorize(int $userId): int;
}