<?php
declare(strict_types=1);

namespace App\Action\User;

use App\Action\Action;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class FindUserAction extends Action
{
    private UserRepositoryInterface $repository;
    public function __construct(ContainerInterface $container)
    {
        $this->repository = $container->get(UserRepositoryInterface::class);
        parent::__construct($container);
    }

    public function action(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        if ($id === null) {
            return $response->withStatus(404);
        }
        $user = $this->repository->findByID($this->context, $id);
        if ($user === null) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode(['id' => $user->getID()]));
        return $response;
    }
}