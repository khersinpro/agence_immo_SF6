<?php

namespace App\Controller\Admin;

use App\Entity\PropertyType;
use App\Form\PropertyTypeType;
use App\Repository\PropertyTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type')]
class PropertyTypeController extends AbstractController
{
    #[Route('/', name: 'app_property_type_index', methods: ['GET'])]
    public function index(PropertyTypeRepository $propertyTypeRepository): Response
    {
        return $this->render('admin/property_type/index.html.twig', [
            'property_types' => $propertyTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_property_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PropertyTypeRepository $propertyTypeRepository): Response
    {
        $propertyType = new PropertyType();
        $form = $this->createForm(PropertyTypeType::class, $propertyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyTypeRepository->save($propertyType, true);

            return $this->redirectToRoute('app_property_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/property_type/new.html.twig', [
            'property_type' => $propertyType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_type_show', methods: ['GET'])]
    public function show(PropertyType $propertyType): Response
    {
        return $this->render('admin/property_type/show.html.twig', [
            'property_type' => $propertyType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PropertyType $propertyType, PropertyTypeRepository $propertyTypeRepository): Response
    {
        $form = $this->createForm(PropertyTypeType::class, $propertyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyTypeRepository->save($propertyType, true);

            return $this->redirectToRoute('app_property_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/property_type/edit.html.twig', [
            'property_type' => $propertyType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_type_delete', methods: ['POST'])]
    public function delete(Request $request, PropertyType $propertyType, PropertyTypeRepository $propertyTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propertyType->getId(), $request->request->get('_token'))) {
            $propertyTypeRepository->remove($propertyType, true);
        }

        return $this->redirectToRoute('app_property_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
