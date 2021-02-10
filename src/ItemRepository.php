<?php

namespace App;

use App\Entities\Item;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class ItemRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(array $data): Item
    {
        $item = new Item();

        $item->setTitle($data['title']);
        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    public function findAll()
    {
        $items = $this->entityManager->getRepository(Item::class)->findAll();

        return $items;
    }
}