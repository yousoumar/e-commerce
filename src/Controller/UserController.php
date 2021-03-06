<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute("app_home");
        }
        return $this->render('user/index.html.twig', [
            'users'=>$userRepository->findAll(),
        ]);
    }
    #[Route('{id}/show', name: 'app_user_show', methods: ['GET'])]
    public function show( User $user): Response
    {
        if($user->getUserIdentifier()!== $this->getUser()->getUserIdentifier()){
            return $this->redirectToRoute("app_home");
        }
        return $this->render('user/show.html.twig', [
            'user'=>$user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        if($user->getUserIdentifier()!== $this->getUser()->getUserIdentifier()){
            return $this->redirectToRoute("app_home");
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_show', ["id"=>$user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository, TokenStorageInterface $tokenStorage): Response
    {
        if($user->getUserIdentifier()!== $this->getUser()->getUserIdentifier()){
            return $this->redirectToRoute("app_home");
        }
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }
        $request->getSession()->invalidate();
        $tokenStorage->setToken(); // TokenStorageInterface

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
