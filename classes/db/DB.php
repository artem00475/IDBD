<?php

namespace classes\db;

use classes\db\handler\ClientProfileHandler;
use classes\db\handler\FeedbackHandler;
use classes\db\handler\MasterLogsHandler;
use classes\db\handler\MasterProfileHandler;
use classes\db\handler\MasterStatusHandler;
use classes\db\handler\OrderHandler;
use classes\db\handler\OrderStatusHandler;
use classes\db\handler\OwnerHandler;
use classes\db\handler\PaymentTypeHandler;
use classes\db\handler\PlanHandler;
use classes\db\handler\QAHandler;
use classes\db\handler\RequestStatusHandler;
use classes\db\handler\ScheduleHandler;
use classes\db\handler\SubscriberHandler;
use classes\db\handler\SupportRequestHandler;
use classes\db\handler\TechniqueHandler;
use classes\db\handler\UserHandler;

abstract class DB
{
    protected static UserHandler $userHandler;
    protected static ClientProfileHandler $clientProfileHandler;
    protected static FeedbackHandler $feedbackHandler;
    protected static MasterLogsHandler $masterLogsHandler;
    protected static MasterStatusHandler $masterStatusHandler;
    protected static MasterProfileHandler $masterProfileHandler;
    protected static OrderHandler $orderHandler;
    protected static OrderStatusHandler $orderStatusHandler;
    protected static OwnerHandler $ownerHandler;
    protected static PaymentTypeHandler $paymentTypeHandler;
    protected static PlanHandler $planHandler;
    protected static QAHandler $QAHandler;
    protected static RequestStatusHandler $requestStatusHandler;
    protected static ScheduleHandler $scheduleHandler;
    protected static SubscriberHandler $subscriberHandler;
    protected static SupportRequestHandler $supportRequestHandler;
    protected static TechniqueHandler $techniqueHandler;
    abstract static function connect();

    abstract static function isConnected(): bool;

    abstract static function getUserHandler(): UserHandler;
    abstract static function getClientProfileHandler(): ClientProfileHandler;
    abstract static function getFeedbackHandler(): FeedbackHandler;
    abstract static function getMasterLogsHandler(): MasterLogsHandler;
    abstract static function getMasterProfileHandler(): MasterProfileHandler;
    abstract static function getMasterStatusHandler(): MasterStatusHandler;
    abstract static function getOrderHandler(): OrderHandler;
    abstract static function getOrderStatusHandler(): OrderStatusHandler;
    abstract static function getOwnerHandler(): OwnerHandler;
    abstract static function getPaymentTypeHandler(): PaymentTypeHandler;
    abstract static function getPlanHandler(): PlanHandler;
    abstract static function getQAHandler(): QAHandler;
    abstract static function getRequestStatusHandler(): RequestStatusHandler;
    abstract static function getSubscriberHandler(): SubscriberHandler;
    abstract static function getSupportRequestHandler(): SupportRequestHandler;
    abstract static function getTechniqueHandler(): TechniqueHandler;
    abstract static function getScheduleHandler(): ScheduleHandler;

}