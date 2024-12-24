<?php
namespace classes\db\handler;
use classes\db\entity\SupportRequest;

interface SupportRequestHandler
{
    function add(SupportRequest $supportRequest): void;
}