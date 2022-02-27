<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: '')]
    public function index(): Response
    {
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
}
