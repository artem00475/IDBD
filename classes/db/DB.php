<?php

namespace classes\db;

use classes\db\handler\ClientProfileHandler;
use classes\db\handler\FeedbackHandler;
use classes\db\handler\MasterLogsHandler;
use classes\db\handler\MasterProfileHandler;
use classes\db\handler\OrderHandler;
use classes\db\handler\OwnerHandler;
use classes\db\handler\PaymentTypeHandler;
use classes\db\handler\PlanHandler;
use classes\db\handler\QAHandler;
use classes\db\handler\ScheduleHandler;
use classes\db\handler\SubscriberHandler;
use classes\db\handler\SupportRequestHandler;
use classes\db\handler\TechniqueHandler;
use classes\db\handler\UserHandler;

abstract class DB
{
    protected static ?UserHandler $userHandler = null;
    protected static ?ClientProfileHandler $clientProfileHandler = null;
    protected static ?FeedbackHandler $feedbackHandler = null;
    protected static ?MasterLogsHandler $masterLogsHandler = null;
    protected static ?MasterProfileHandler $masterProfileHandler = null;
    protected static ?OrderHandler $orderHandler = null;
    protected static ?OwnerHandler $ownerHandler = null;
    protected static ?PaymentTypeHandler $paymentTypeHandler = null;
    protected static ?PlanHandler $planHandler = null;
    protected static ?QAHandler $QAHandler = null;
    protected static ?ScheduleHandler $scheduleHandler = null;
    protected static ?SubscriberHandler $subscriberHandler = null;
    protected static ?SupportRequestHandler $supportRequestHandler = null;
    protected static ?TechniqueHandler $techniqueHandler = null;
    abstract static function connect();

    abstract static function isConnected(): bool;

    abstract static function getUserHandler(): UserHandler;
    abstract static function getClientProfileHandler(): ClientProfileHandler;
    abstract static function getFeedbackHandler(): FeedbackHandler;
    abstract static function getMasterLogsHandler(): MasterLogsHandler;
    abstract static function getMasterProfileHandler(): MasterProfileHandler;
    abstract static function getOrderHandler(): OrderHandler;
    abstract static function getOwnerHandler(): OwnerHandler;
    abstract static function getPaymentTypeHandler(): PaymentTypeHandler;
    abstract static function getPlanHandler(): PlanHandler;
    abstract static function getQAHandler(): QAHandler;
    abstract static function getSubscriberHandler(): SubscriberHandler;
    abstract static function getSupportRequestHandler(): SupportRequestHandler;
    abstract static function getTechniqueHandler(): TechniqueHandler;
    abstract static function getScheduleHandler(): ScheduleHandler;

}