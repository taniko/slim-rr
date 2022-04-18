<?php
declare(strict_types=1);

use App\Action\Ping;
use App\Action\User\CreateUserAction;
use App\Action\User\FindUserAction;
use App\Action\User\ListUsersAction;
use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('ok');
        return $response;
    });
    $app->get('/ping', Ping::class);
    $app->post('/users', CreateUserAction::class);
    $app->get('/users', ListUsersAction::class);
    $app->get('/users/{id}', FindUserAction::class);
};