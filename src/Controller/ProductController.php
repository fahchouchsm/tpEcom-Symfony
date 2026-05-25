<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(CategoryRepository $categoryRepository): Response
    {
        return $this->render('product/home.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/products', name: 'product_list')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product_details')]
    public function details(Product $product): Response
    {
        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/categories', name: 'category_list')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('product/categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{slug}', name: 'category_products')]
    public function productsByCategory(Category $category): Response
    {
        return $this->render('product/products_by_category.html.twig', [
            'category' => $category,
            'products' => $category->getProducts(),
        ]);
    }

    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('security/profile.html.twig');
    }

    #[Route('/products/seed', name: 'product_seed')]
    public function seed(EntityManagerInterface $em): Response
    {
        $categories = [
            ['Electronics', 'electronics', 'Headphones, speakers and gadgets'],
            ['Fashion', 'fashion', 'Clothes, jackets and accessories'],
            ['Home & Garden', 'home-garden', 'Products for home and garden'],
            ['Sports & Fitness', 'sports', 'Workout gear, yoga mats and equipment'],
            ['Books', 'books', 'Books and learning products'],
            ['Beauty & Health', 'beauty', 'Skincare, cosmetics and wellness'],
            ['Toys & Games', 'toys', 'Fun for kids and family entertainment'],
            ['Automotive', 'automotive', 'Car accessories and maintenance tools'],
            ['Pet Supplies', 'pets', 'Food, toys and accessories for pets'],
        ];

        $savedCategories = [];

        foreach ($categories as [$name, $slug, $description]) {
            $category = new Category();
            $category->setName($name);
            $category->setSlug($slug);
            $category->setDescription($description);
            $em->persist($category);
            $savedCategories[$slug] = $category;
        }

        $products = [
            ['Wireless Headphones', '79.99', 'Experience premium sound quality with our wireless headphones. Featuring advanced noise cancellation technology, comfortable over-ear design, and up to 30 hours of battery life.', 'item.png', 'electronics'],
            ['Classic Leather Jacket', '149.99', 'A classic leather jacket for everyday style.', 'item.png', 'fashion'],
            ['Smart Plant Sensor', '34.99', 'Simple sensor to follow your plant health.', 'item.png', 'home-garden'],
            ['Yoga Mat Premium', '29.99', 'Premium yoga mat for sport and fitness.', 'item.png', 'sports'],
            ['Bluetooth Speaker', '59.99', 'Portable speaker with a clean and powerful sound.', 'item.png', 'electronics'],
            ['Web Development Guide', '24.99', 'A beginner friendly book for web development.', 'item.png', 'books'],
            ['Smartphone Stand', '19.99', 'Useful smartphone stand for your desk.', 'mouse.png', 'electronics'],
            ['USB-C Cable 2m', '12.99', 'Strong USB-C cable with fast charging support.', 'mouse.png', 'electronics'],
            ['Wireless Mouse', '29.99', 'Comfortable wireless mouse for work and gaming.', 'mouse.png', 'electronics'],
            ['Mechanical Keyboard', '89.99', 'Mechanical keyboard with responsive keys.', 'mouse.png', 'electronics'],
            ['Webcam HD 1080p', '49.99', 'HD webcam for meetings and streaming.', 'mouse.png', 'electronics'],
            ['Power Bank 20000mAh', '39.99', 'Large capacity power bank for travel.', 'mouse.png', 'electronics'],
            ['Smart Watch Pro', '199.99', 'Smart watch with fitness tracking.', 'mouse.png', 'electronics'],
        ];

        foreach ($products as [$name, $price, $description, $image, $categorySlug]) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->setImage($image);
            $product->setCategory($savedCategories[$categorySlug]);
            $em->persist($product);
        }

        $em->flush();

        return $this->redirectToRoute('product_list');
    }
}
