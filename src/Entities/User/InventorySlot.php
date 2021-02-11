<?php

namespace App\Entities\User;

use App\Entities\Item;
use App\Entities\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="inventories")
 */
class InventorySlot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User", inversedBy="inventory")
     */
    private User $user;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="App\Entities\Item", fetch="EAGER")
     */
    private Item $item;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $count = null;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function setItem(Item $item): void
    {
        $this->item = $item;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): void
    {
        $this->count = $count;
    }

    public function add(int $count)
    {
        $this->count += $count;
    }
}