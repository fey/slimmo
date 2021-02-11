<?php

namespace App;

use App\Entities\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function create($name): User
    {
        $user = new User();
        $user->setName($name);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }
}