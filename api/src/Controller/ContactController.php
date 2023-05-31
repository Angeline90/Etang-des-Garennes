<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/app/contact', name: 'app_contact')]
    public function index(
        Request $request, 
        ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        // pour pré-remplir le form si l'user est déjà connecté
        // table user a mettre a jour avec le nom
        // if($this->getUser()) {
        //     $contact->setFullName($this->getUser()->getName())
        //         ->setEmail($this->getUser()->getEmail());
        // }
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->save($contact,true);
          
            $this->addFlash(
                'success', 
                'Votre message a bien été envoyé !'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
