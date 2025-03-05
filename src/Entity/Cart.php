<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Guid\Guid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="cart:read"},
 *     denormalizationContext={"groups"="cart:write"},
 *     collectionOperations={
 *         "get" = {},
 *         "post" = {}
 *     },
 *     itemOperations={
 *         "get" = {},
 *         "put" = {},
 *         "delete" = {}
 *     }
 * )
 * @ORM\Entity
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", unique=true)
     */
    private $id;

    /**
     * @var CartItem[]|array
     * @Groups({"cart:read", "cart:write"})
     */
    private $items = [];

    public function __construct()
    {
        $this->id = Guid::uuid4()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(CartItem $cartItem)
    {
        foreach ($this->items as $key => $item) {
            if ($cartItem->matches($item)) {
                $this->items[$key] = $cartItem;
                return;
            }
        }

        $this->items[] = $cartItem;
    }

    public function removeItem(CartItem $cartItem)
    {
        foreach ($this->items as $key => $item) {
            if ($cartItem->matches($item)) {
                unset($this->items[$key]);
                $this->items = array_values($this->items);
                return;
            }
        }
    }
}
