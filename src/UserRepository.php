<?php

namespace App;

use App\Entities\User;
use Doctrine\ORM\EntityManager;

class UserRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        $repo = $this->entityManager->getRepository(User::class);

        return $repo->findAll();
    }

    public function find($id): ?User
    {
        $repo = $this->entityManager->getRepository(User::class);

        return $repo->find($id);
    }

    public function create($name): User
    {
        $user = new User();
        $user->setName($name);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}