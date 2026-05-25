<?php

namespace App\Cart;

interface CartInterface
{
    public function add(CartItem $item): void;

    public function remove(int $productId): void;

    public function clear(): void;

    public function getItems(): array;
}
