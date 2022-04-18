<?php
declare(strict_types=1);

namespace App\Action\User;

use App\Action\Action;
use App\Domain\Repository\UserRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListUsersAction extends Action
{
    private UserRepositoryInterface $repository;

    public function __construct(ContainerInterface $container)
    {
        $this->repository = $container->get(UserRepositoryInterface::class);
        parent::__construct($container);
    }

    public function action(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $users = [];
        foreach ($this->repository->list($this->context) as $user) {
            $users[] = ['id' => $user->getID(), 'name' => $user->getName()];
        }
        $response->getBody()->write(json_encode(['users' => $users]));
        return $response;
    }
}