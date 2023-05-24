<?php

namespace App\Controller;

use App\Entity\Cottage;
use App\Form\CottageType;
use App\Repository\CottageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[
    Route('/app/cottage'),
    IsGranted('ROLE_USER')
]
class CottageController extends AbstractController
{
    #[Route('/', name: 'app_cottage_index', methods: ['GET'])]
    public function index(CottageRepository $cottageRepository): Response
    {
        // dd($this->getUser()->getCottages()->getValues());
        $cottages = $this->isGranted('ROLE_ADMIN')
            ? $cottageRepository->findAll() : $this->getUser()->getCottages();
        return $this->render('cottage/index.html.twig', [
            'cottages' => $cottages,
        ]);
    }

    #[Route('/new', name: 'app_cottage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CottageRepository $cottageRepository, UserRepository $userRepository): Response
    {
        $cottage = new Cottage();
        $owners = $this->isGranted('ROLE_ADMIN')
            ? $userRepository->findAll() : [$this->getUser()];
        $form = $this->createForm(CottageType::class, $cottage, ['owners' => $owners]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cottageRepository->save($cottage, true);

            return $this->redirectToRoute('app_cottage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cottage/new.html.twig', [
            'cottage' => $cottage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cottage_show', methods: ['GET'])]
    public function show(Cottage $cottage): Response
    {
        return $this->render('cottage/show.html.twig', [
            'cottage' => $cottage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cottage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cottage $cottage, CottageRepository $cottageRepository, UserRepository $userRepository): Response
    {
        $owners = $this->isGranted('ROLE_ADMIN')
        ? $userRepository->findAll() : [$this->getUser()];
        $form = $this->createForm(CottageType::class, $cottage, ['owners' => $owners]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cottageRepository->save($cottage, true);

            return $this->redirectToRoute('app_cottage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cottage/edit.html.twig', [
            'cottage' => $cottage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cottage_delete', methods: ['POST'])]
    public function delete(Request $request, Cottage $cottage, CottageRepository $cottageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cottage->getId(), $request->request->get('_token'))) {
            $cottageRepository->remove($cottage, true);
        }

        return $this->redirectToRoute('app_cottage_index', [], Response::HTTP_SEE_OTHER);
    }
}
