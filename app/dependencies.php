<?php
declare(strict_types=1);

use App\Container;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Datastore\User\FileCacheUserRepository;
use App\Logger\Processor\RemoveContextProcessor;
use App\Logger\Processor\RequestIDProcessor;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return (function (): ContainerInterface {
    $logger = new Logger('slim-rr');
    $formatter = new JsonFormatter(appendNewline: false);
    $formatter->setDateFormat(DATE_ATOM);
    $handler = new StreamHandler('php://stderr');
    $handler->setFormatter($formatter);
    $handler->pushProcessor(new RemoveContextProcessor());
    $handler->pushProcessor(new RequestIDProcessor());
    $logger->pushHandler($handler);

    return new Container(
        [
            LoggerInterface::class => $logger,
            UserRepositoryInterface::class => new FileCacheUserRepository($logger,__DIR__ . '/../cache/users.json'),
        ]
    );
})();