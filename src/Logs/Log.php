<?php

namespace App\Logs;

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log {

    static function getLogger() {
        $logger = new Logger('my_logger');
        
        $logger->pushHandler(new StreamHandler('../logs/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }
}
