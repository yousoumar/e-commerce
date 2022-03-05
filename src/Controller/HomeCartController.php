<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class HomeCartController extends AbstractController
{


    #[Route('/', name: '')]
    public function index(Request $request): Response

    {
        $session = $request->getSession();
        $cart= $session->get("cart");
        if(!$cart){
            $cart=[];
        }

        $session->set("cart",$cart);

        return $this->redirect("/home");
    }

    #[Route('/home', name: 'app_home')]
    public function home(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/cart', name: 'app_cart')]
    public function cart(ProductRepository $productRepository,Request $request): Response
    {
        $session = $request->getSession();
        $cart =  $session->get("cart");

        if(!$cart){
            $cart=[];
        }
        $session->set("cart",$cart);
        $products = $productRepository->findBy(array('id' => $cart));
        $totalPrice =  array_sum(array_map(fn($p): int => $p->getPrice(), $products));
        return $this->render('cart/index.html.twig', [
            'products'=>  $products,
            "totalPrice"=>$totalPrice
        ]);
    }
}
