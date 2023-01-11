<?php

namespace App\Controller\Admin;

use App\Entity\PropertyPicture;
use App\Repository\PropertyPictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/admin/picture/{id}', name: 'admin.picture.delete', methods: 'DELETE')]
    public function index(Request $request, PropertyPicture $picture, PropertyPictureRepository $pictureRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'] )) {
            $pictureRepository->remove($picture, true);
            return new JsonResponse(['success' => 1]);
        }
        
        return new JsonResponse(['error' => 1]);
    }
}
