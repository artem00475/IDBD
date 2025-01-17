<?php

namespace classes\db\handler;

use classes\db\entity\Feedback;

interface FeedbackHandler
{
    function add(Feedback $feedback): void;
}