<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Entity\PropertyPicture;
use App\Entity\PropertySearch;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isType;

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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();

        $properties = $this->propertyRepository->findAll();
        $properties =  $paginator->paginate(
            $this->propertyRepository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filesToUpload = $property->getPicturesArray() ?? null;
            
            if ($filesToUpload) {
                // Upload images and return array of filename
                $allFilenames = $fileUploader->uploadImage($filesToUpload);
                // Todo => set une image de thumb differente lié a la property qui ne dépend pas de PropertyPictureEntity
                // $property->setThumb($allFilenames[0]);

                foreach($allFilenames as $filename) {
                    $propertyPicture = new PropertyPicture();
                    $propertyPicture->setPicture($filename);

                    $property->addPropertyPicture($propertyPicture);
                    $this->manager->persist($propertyPicture);
                }
            }
            
            $this->propertyRepository->save($property, true);
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
    public function edit(Property $property, Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filesToUpload = $property->getPicturesArray() ?? null;
            
            if ($filesToUpload) {
                // Upload images and return array of filename
                $allFilenames = $fileUploader->uploadImage($filesToUpload);
                $property->setThumb($allFilenames[0]);

                foreach($allFilenames as $filename) {
                    $propertyPicture = new PropertyPicture();
                    $propertyPicture->setPicture($filename);

                    $property->addPropertyPicture($propertyPicture);
                    $this->manager->persist($propertyPicture);
                }
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
     * @Route("/admin/property/delete/{id<\d+>}", name="admin.property.delete", methods="DELETE")
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
