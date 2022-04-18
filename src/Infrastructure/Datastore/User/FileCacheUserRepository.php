<?php
declare(strict_types=1);

namespace App\Infrastructure\Datastore\User;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Taniko\Context\ContextInterface;

class FileCacheUserRepository implements UserRepositoryInterface
{
    /**
     * @param LoggerInterface $logger
     * @param string $path /path/to/users.json
     */
    public function __construct(private readonly LoggerInterface $logger, private readonly string $path)
    {
    }

    /**
     * @param ContextInterface $context
     * @param User $user
     * @return User
     */
    public function store(ContextInterface $context, User $user): User
    {
        $users = $this->load();
        $users[$user->getID()] = $user;
        $this->save($users);
        $log = [ContextInterface::class => $context, 'user' => [
            'id' => $user->getID(),
        ]];
        $this->logger->info('store user to file', $log);
        return $user;
    }

    /**
     * @param ContextInterface $context
     * @param string $id
     * @return User|null
     */
    public function findByID(ContextInterface $context, string $id): User|null
    {
        $users = $this->load();
        return $users[$id] ?? null;
    }

    /**
     * load users
     * @return array<string,User>
     */
    private function load(): array
    {
        $users = [];
        if (file_exists($this->path)) {
            $data = json_decode(file_get_contents($this->path), true);
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (isset($item['id']) && is_string($item['id']) && isset($item['name']) && is_string($item['name'])) {
                        $users[$item['id']] = new User($item['id'], $item['name']);
                    }
                }
            }
        }
        return $users;
    }

    /**
     * save users
     * @param array<string,User> $users
     * @return void
     */
    private function save(array $users): void
    {
        $data = [];
        foreach ($users as $user) {
            $data[] = ['id' => $user->getID(), 'name' => $user->getName()];
        }
        file_put_contents($this->path, json_encode($data));
    }

    /**
     * @param ContextInterface $context
     * @return User[]
     */
    public function list(ContextInterface $context): array
    {
        return $this->load();
    }
}