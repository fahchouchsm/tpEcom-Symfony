<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function add(CartItem $item): void
    {
        $cart = $this->getItems();
        $productId = $item->getProductId();

        if (!isset($cart[$productId])) {
            $cart[$productId] = 0;
        }

        $cart[$productId] += $item->getQuantity();
        $this->save($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getItems();
        unset($cart[$productId]);
        $this->save($cart);
    }

    public function clear(): void
    {
        $this->save([]);
    }

    public function getItems(): array
    {
        return $this->requestStack->getSession()->get('cart', []);
    }

    private function save(array $cart): void
    {
        $this->requestStack->getSession()->set('cart', $cart);
    }
}
