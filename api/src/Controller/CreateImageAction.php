<?php

namespace App\Controller;

use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class CreateImageAction extends AbstractController
{
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
        // dd($cottage);
    }
}
