<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;
use Taniko\Context\ContextInterface;

interface UserRepositoryInterface
{
    /**
     * @param ContextInterface $context
     * @param User $user
     * @return User
     */
    public function store(ContextInterface $context, User $user): User;

    /**
     * @param ContextInterface $context
     * @param string $id
     * @return User|null
     */
    public function findByID(ContextInterface $context, string $id): User|null;


    /**
     * @param ContextInterface $context
     * @return User[]
     */
    public function list(ContextInterface $context): array;
}