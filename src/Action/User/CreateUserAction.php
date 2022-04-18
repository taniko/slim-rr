<?php
declare(strict_types=1);

namespace App\Action\User;

use App\Action\Action;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use JsonException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Taniko\Context\ContextInterface;

class CreateUserAction extends Action
{
    private UserRepositoryInterface $repository;

    public function __construct(ContainerInterface $container)
    {
        $this->repository = $container->get(UserRepositoryInterface::class);
        parent::__construct($container);
    }

    public function action(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $context = [ContextInterface::class => $this->context];
        $this->logger->info('call CreateUserAction', $context);
        try {
            $body = json_decode((string)$request->getBody(), true, flags: JSON_THROW_ON_ERROR);
            if (!$this->validate($body)) {
                $response->getBody()->write(json_encode(['errors' => ['name' => ['required']]]));
                return $response->withStatus(400);
            }
        } catch (JsonException) {
            $response->getBody()->write(json_encode(['errors' => ['json' => ['invalid']]]));
            return $response->withStatus(400);
        }
        $this->logger->debug('new user', ['body' => $body]);
        $user = new User(Uuid::uuid4()->toString(), $body['name']);
        $user = $this->repository->store($this->context, $user);
        $context['user-id'] = $user->getID();
        $this->logger->info('create user', $context);
        $response->getBody()->write(json_encode([
            'id' => $user->getID(),
            'name' => $user->getName(),
        ]));
        return $response;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        return isset($data['name']) && is_string($data['name']);
    }
}