<?php


namespace App\Infrastructure\Log;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LogstashLogger
{
    public function __invoke(array $config): LoggerInterface
    {
        $handler = new StreamHandler($config['path']);
        $handler->setFormatter(new LogstashFormatter(config('app.name')));
        return new Logger('logstash.main', [$handler]);
    }
}
