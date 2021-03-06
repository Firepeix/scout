<?php

use App\Infrastructure\Log\LogstashLogger;
use Lancelot\Log\Infrastructure\Events\NewLogEvent;
use Lancelot\Log\Infrastructure\Log\LancelotLogger;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['lancelot', 'backup'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'custom',
            'via'    => LogstashLogger::class,
            'path' => storage_path('logs/app.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'backup' => [
            'driver' => 'custom',
            'via'    => LogstashLogger::class,
            'path' => storage_path('logs/backup.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'lancelot' => [
            'driver' => 'custom',
            'via'    => LancelotLogger::class,
            'event' => NewLogEvent::class,
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stdout' => [
            'driver' => 'custom',
            'via'    => LogstashLogger::class,
            'path' => '/dev/stdout',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
        'logstash' => [
            'driver' => 'custom',
            'via'    => LogstashLogger::class,
            'host'   => env('LOGSTASH_HOST', '127.0.0.1'),
            'port'   => env('LOGSTASH_PORT', 4718),
        ],
    ],

];
