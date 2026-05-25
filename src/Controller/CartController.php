<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Cart\CartItem;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(CartHandler $cartHandler, ProductRepository $productRepository): Response
    {
        $cartLines = [];
        $total = 0;

        foreach ($cartHandler->getItems() as $productId => $quantity) {
            $product = $productRepository->find($productId);

            if ($product === null) {
                continue;
            }

            $lineTotal = (float) $product->getPrice() * $quantity;
            $total += $lineTotal;

            $cartLines[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $lineTotal,
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cartLines' => $cartLines,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request, CartHandler $cartHandler): Response
    {
        $quantity = max(1, (int) $request->request->get('quantity', 1));

        $cartHandler->add(new CartItem($id, $quantity));
        $this->addFlash('success', 'Product added to cart.');

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(int $id, CartHandler $cartHandler): Response
    {
        $cartHandler->remove($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/clear', name: 'cart_clear', methods: ['POST'])]
    public function clear(CartHandler $cartHandler): Response
    {
        $cartHandler->clear();

        return $this->redirectToRoute('cart');
    }
}
