<?php

namespace App\Cart;

class ApiCart implements CartInterface
{
    public function add(CartItem $item): void
    {
        dd('add product with API');
    }

    public function remove(int $productId): void
    {
        dd('remove product with API');
    }

    public function clear(): void
    {
        dd('clear cart with API');
    }

    public function getItems(): array
    {
        dd('get cart with API');
    }
}
