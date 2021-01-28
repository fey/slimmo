<?php

namespace App;

use App\Entities\User;
use Doctrine\ORM\EntityManager;

class UserRepository
{
    private array $users;
    /**
     * @var EntityManager
     */
    private ?EntityManager $entityManager = null;

    public function __construct(EntityManager $entityManager)
    {

        $range = range(1, 10);

        $this->users = array_map(fn($id) => new User($id, "User $id"), $range);

        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->users;
    }

    public function find($id): ?User
    {
        return $this->users[$id - 1] ?? null;
    }
}