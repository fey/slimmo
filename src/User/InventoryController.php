<?php

namespace App\User;

use App\Entities\Item;
use App\Entities\User;
use App\Entities\User\InventorySlot;
use App\InventoryRepository;
use App\ItemRepository;
use App\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use function App\functions\withJson;

class InventoryController
{
    private EntityManager $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function index(Request $request, Response $response, int $userId)
    {
        $user = $this->findUser($userId);
        //
        //$dql = "SELECT slot, item from App\Entities\User\InventorySlot slot JOIN slot.item item where slot.user = :user";
        //
        //$query = $this->entityManager->createQuery($dql);
        //$query->setParameter('user', $user);
        //$result = $query->getResult();

        return withJson($response, [
           'items' => //(new ArrayCollection($result))
                $user->getInventory()
                ->map(function (InventorySlot $inventorySlot) {
                    return [
                        'item' => $inventorySlot->getItem()->getTitle(),
                        'count' => $inventorySlot->getCount(),
                    ];
                })
                ->getValues(),
            'total_count' => $user->getInventory()->count()
        ]);
    }

    public function add(Request $request, Response $response, int $userId): Response
    {
        ['item_id' => $itemId, 'count' => $count] = $request->getParsedBody();
        $user = $this->findUser($userId);
        $item = $this->entityManager->find(Item::class, $itemId);
        $inventoryRepository = $this->entityManager->getRepository(InventorySlot::class);
        $inventorySlot = $inventoryRepository->findOneBy([
            'user' => $user,
            'item' => $item,
        ]);
        if ($inventorySlot === null) {
            $inventorySlot = new InventorySlot();
            $inventorySlot->setItem($item);
            $inventorySlot->setUser($user);
            $inventorySlot->setCount(0);
        }
        $inventorySlot->add($count);
        $this->entityManager->persist($inventorySlot);
        $this->entityManager->flush();
        return $response;
    }

    private function findUser(int $userId): User
    {
        return $this->entityManager->find(User::class, $userId);
    }
}