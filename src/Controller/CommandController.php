<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/command')]
class CommandController extends AbstractController
{
    #[Route('/', name: 'app_command')]
    public function index(CommandRepository $commandRepository): Response
    {
        if(!$this->isGranted('ROLE_USER')){
            return $this->redirectToRoute("app_home");
        }
        if($this->isGranted('ROLE_ADMIN')){
            return $this->render('command/index.html.twig', [
                'commands' => $commandRepository->findAll(),
                "admin"=>true
            ]);

        }

        return $this->render('command/index.html.twig', [
            'commands' => $commandRepository->findBy(["customer"=>$this->getUser()]),
            "admin"=>false
        ]);
    }
    #[Route('/new', name: 'app_command_new')]
    public function new(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {

        if(!$this->isGranted('ROLE_USER')){
            return $this->redirectToRoute("app_login");
        }

        $session = $request->getSession();
        $cart = $session->get("cart");
        $products = $productRepository->findBy(array('id' => $cart));
        $totalPrice =  array_sum(array_map(fn($p): int => $p->getPrice(), $products));

        if(empty($cart)){
            return $this->redirectToRoute("app_home");
        }
        $command = new Command();
        $command->setDate(new \DateTime());
        $command->setTotal($totalPrice);
        $command->setCustomer($this->getUser());
        $entityManager->persist($command);
        $entityManager->flush($command);
        $session->set("cart", []);


        return $this->render('command/success.html.twig');
    }
}
