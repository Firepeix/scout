<?php


namespace Lancelot\Log\Infrastructure\Log;


use Monolog\Formatter\LogstashFormatter;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LancelotLogger
{
    public function __invoke(array $config): LoggerInterface
    {
        $handler = new LancelotHandler($config['event']);
        $handler->setFormatter(new LogstashFormatter(config('app.name')));
        return new Logger('logstash.main', [$handler]);
    }
}
