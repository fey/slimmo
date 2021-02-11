<?php

namespace App;

use App\Entities\Item;
use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function create(array $data): Item
    {
        $item = new Item();

        $item->setTitle($data['title']);
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();

        return $item;
    }
}