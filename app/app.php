<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

/** @var ContainerInterface $container */
$container = require sprintf("%s/dependencies.php", __DIR__);
$app = AppFactory::create(container: $container);
$routes = require __DIR__ . '/routes.php';
$routes($app);
$middleware = require __DIR__ . '/middleware.php';
$middleware($app);
return $app;
