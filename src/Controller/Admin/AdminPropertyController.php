<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(PropertyRepository $propertyRepository, EntityManagerInterface $manager)
    {
        $this->propertyRepository = $propertyRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index(): Response
    {
        $properties = $this->propertyRepository->findAll();

        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->propertyRepository->add($property, true);
            $this->addFlash('success', 'Bien créer avec succès.');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id<\d+>}", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request, FileUploader $fileUp): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->getExtraData()) {
                // $fileUp->uploadPropertyImage()
                dd($form->getExtraData());
            }
            $this->manager->flush();
            $this->addFlash('success', 'Le bien a été modifier avec succès.');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id<\d+>}", name="admin.property.delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $this->propertyRepository->remove($property, true);
            $this->addFlash('success', 'Bien supprimer avec succès.');
        }

        return $this->redirectToRoute('admin.property.index');
    }
}
