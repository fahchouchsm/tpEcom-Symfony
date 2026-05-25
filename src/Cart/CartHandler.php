<?php

namespace App\Cart;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    public function __construct(
        #[Autowire(service: SessionCart::class)]
        private CartInterface $cart,
    ) {
    }

    public function add(CartItem $item): void
    {
        $this->cart->add($item);
    }

    public function remove(int $productId): void
    {
        $this->cart->remove($productId);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }

    public function getItems(): array
    {
        return $this->cart->getItems();
    }
}
