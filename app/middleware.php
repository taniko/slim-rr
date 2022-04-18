<?php
declare(strict_types=1);

use Slim\App;
use App\Middleware\RequestIDMiddleware;

return function (App $app) {
    $app->add(RequestIDMiddleware::class);
};