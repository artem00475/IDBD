<?php

namespace classes\db;

use classes\db\handler\ClientProfileHandler;
use classes\db\handler\FeedbackHandler;
use classes\db\handler\impl\ClientProfileHandlerImpl;
use classes\db\handler\impl\FeedbackHandlerImpl;
use classes\db\handler\impl\MasterLogsHandlerImpl;
use classes\db\handler\impl\MasterProfileHandlerImpl;
use classes\db\handler\impl\OrderHandlerImpl;
use classes\db\handler\impl\OwnerHandlerImpl;
use classes\db\handler\impl\PaymentTypeHandlerImpl;
use classes\db\handler\impl\PlanHandlerImpl;
use classes\db\handler\impl\QAHandlerImpl;
use classes\db\handler\impl\ScheduleHandlerImpl;
use classes\db\handler\impl\SubscriberHandlerImpl;
use classes\db\handler\impl\SupportRequestHandlerImpl;
use classes\db\handler\impl\TechniqueHandlerImpl;
use classes\db\handler\impl\UserHandlerImpl;
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
use PDO;
use PDOException;

class DBPostgres extends DB
{

    private static string $dsn = "pgsql:host=pg" .
        ";port=5432;dbname=studs" .
        ";user=" .
        ";password=" ;

    private static ?PDO $db_connect = null;
    static function connect(): void
    {
        try {
            self::$db_connect = new PDO(self::$dsn);
        } catch (PDOException $exception) {
            $msg = $exception->getMessage();
            echo $msg .
                ". Do not forget to enable in the web server the database 
                manager for php and in the database instance authorize the 
                ip of the server instance if they not in the same 
                instance.";
        }
    }

    static function isConnected(): bool
    {
        return self::$db_connect !== null;
    }

    static function getConnection(): PDO
    {
        return self::$db_connect;
    }

    static function getUserHandler(): UserHandler
    {
        if (!static::$userHandler) {
            static::$userHandler = new UserHandlerImpl();
        }
        return static::$userHandler;
    }

    static function getClientProfileHandler(): ClientProfileHandler
    {
        if (!static::$clientProfileHandler) {
            static::$clientProfileHandler = new ClientProfileHandlerImpl();
        }
        return static::$clientProfileHandler;
    }

    static function getFeedbackHandler(): FeedbackHandler
    {
        if (!static::$feedbackHandler) {
            static::$feedbackHandler = new FeedbackHandlerImpl();
        }
        return static::$feedbackHandler;
    }

    static function getMasterLogsHandler(): MasterLogsHandler
    {
        if (!static::$masterLogsHandler) {
            static::$masterLogsHandler = new MasterLogsHandlerImpl();
        }
        return static::$masterLogsHandler;
    }

    static function getMasterProfileHandler(): MasterProfileHandler
    {
        if (!static::$masterProfileHandler) {
            static::$masterProfileHandler = new MasterProfileHandlerImpl();
        }
        return static::$masterProfileHandler;
    }


    static function getOrderHandler(): OrderHandler
    {
        if (!static::$orderHandler) {
            static::$orderHandler = new OrderHandlerImpl();
        }
        return static::$orderHandler;
    }


    static function getOwnerHandler(): OwnerHandler
    {
        if (!static::$ownerHandler) {
            static::$ownerHandler = new OwnerHandlerImpl();
        }
        return static::$ownerHandler;
    }

    static function getPaymentTypeHandler(): PaymentTypeHandler
    {
        if (!static::$paymentTypeHandler) {
            static::$paymentTypeHandler = new PaymentTypeHandlerImpl();
        }
        return static::$paymentTypeHandler;
    }

    static function getPlanHandler(): PlanHandler
    {
        if (!static::$planHandler) {
            static::$planHandler = new PlanHandlerImpl();
        }
        return static::$planHandler;
    }

    static function getQAHandler(): QAHandler
    {
        if (!static::$QAHandler) {
            static::$QAHandler = new QAHandlerImpl();
        }
        return static::$QAHandler;
    }


    static function getSubscriberHandler(): SubscriberHandler
    {
        if (!static::$subscriberHandler) {
            static::$subscriberHandler = new SubscriberHandlerImpl();
        }
        return static::$subscriberHandler;
    }

    static function getSupportRequestHandler(): SupportRequestHandler
    {
        if (!static::$supportRequestHandler) {
            static::$supportRequestHandler = new SupportRequestHandlerImpl();
        }
        return static::$supportRequestHandler;
    }

    static function getTechniqueHandler(): TechniqueHandler
    {
        if (!static::$techniqueHandler) {
            static::$techniqueHandler = new TechniqueHandlerImpl();
        }
        return static::$techniqueHandler;
    }

    static function getScheduleHandler(): ScheduleHandler
    {
        if (!static::$scheduleHandler) {
            static::$scheduleHandler = new ScheduleHandlerImpl();
        }
        return static::$scheduleHandler;
    }
}