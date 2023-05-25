<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path:'app/profile', name:'app_profile_')]
class ProfileController extends AbstractController
{

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(): Response
    {
        $user = $this->getUser();
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_profile_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/delete', name: 'delete', methods: ['POST'])]
    // public function delete(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $userRepository->remove($user, true);
    //     }

    //     return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    // }
}
