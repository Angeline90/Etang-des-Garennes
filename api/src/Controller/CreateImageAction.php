<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Cottage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class CreateImageAction extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function __invoke(Request $request): Image
    {

        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new Image();
        $mediaObject->file = $uploadedFile;

        return $mediaObject;
    }

    #[Route('/app/cottage/{id}/add-banner', name: 'app_images_cottage_banner', methods: ['POST'])]
    public function addCottageBanner(Cottage $cottage, Request $request)
    {
        $mediaObject = $this->__invoke($request);
        $this->manager->persist($mediaObject);
        $cottage->setBanner($mediaObject);
        $this->manager->flush();


        return $this->redirectToRoute('app_cottage_edit', ['id' => $cottage->getId()]);

    }

    
    #[Route('/app/cottage/{id}/add-img-card', name: 'app_images_cottage_card', methods: ['POST'])]
    public function addCottageCard(Cottage $cottage, Request $request)
    {
        $mediaObject = $this->__invoke($request);
        $this->manager->persist($mediaObject);
        $cottage->setCard($mediaObject);
        $this->manager->flush();


        return $this->redirectToRoute('app_cottage_edit', ['id' => $cottage->getId()]);

    }
}
