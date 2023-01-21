<?php

namespace App\Controller\Admin;

use App\Entity\PropertyHeat;
use App\Form\PropertyHeatType;
use App\Repository\PropertyHeatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/property/heat')]
class PropertyHeatController extends AbstractController
{
    #[Route('/', name: 'admin.heat.index', methods: ['GET'])]
    public function index(PropertyHeatRepository $propertyHeatRepository): Response
    {
        return $this->render('admin/property_heat/index.html.twig', [
            'property_heats' => $propertyHeatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin.heat.new', methods: ['GET', 'POST'])]
    public function new(Request $request, PropertyHeatRepository $propertyHeatRepository): Response
    {
        $propertyHeat = new PropertyHeat();
        $form = $this->createForm(PropertyHeatType::class, $propertyHeat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyHeatRepository->save($propertyHeat, true);

            return $this->redirectToRoute('admin.heat.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/property_heat/new.html.twig', [
            'property_heat' => $propertyHeat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin.heat.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PropertyHeat $propertyHeat, PropertyHeatRepository $propertyHeatRepository): Response
    {
        $form = $this->createForm(PropertyHeatType::class, $propertyHeat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyHeatRepository->save($propertyHeat, true);

            return $this->redirectToRoute('admin.heat.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/property_heat/edit.html.twig', [
            'property_heat' => $propertyHeat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin.heat.delete', methods: ['DELETE'])]
    public function delete(Request $request, PropertyHeat $propertyHeat, PropertyHeatRepository $propertyHeatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propertyHeat->getId(), $request->request->get('_token'))) {
            $propertyHeatRepository->remove($propertyHeat, true);
        }

        return $this->redirectToRoute('admin.heat.index', [], Response::HTTP_SEE_OTHER);
    }
}
