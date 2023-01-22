<?php

namespace App\Controller;

use App\Entity\ContactMail;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactMailType;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Service\MailManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }
    
    #[Route("/biens", name: "property.index")]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        
        $properties =  $paginator->paginate(
            $this->propertyRepository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12,
            ['distinct' => false]
        );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    #[Route("/biens/{slug}-{id}", name: "property.show", requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show($slug, $id, Property $property, Request $request, MailManager $mailManager): Response
    {
        if ($slug !== $property->getSlug()) {
            return $this->redirectToRoute('property.show', [
                'slug' => $property->getSlug(), 
                'id' => $id
            ], 301);
        }

        $contact = new ContactMail();
        $contact->setProperty($property);
        $form = $this->createForm(ContactMailType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailManager->sendPropertyEmailContact($contact);
            $this->addFlash('success', 'Votre mail de contact a bien été transmis.');
            $this->redirectToRoute('property.show', [
                'slug' => $slug,
                'id' => $id
            ]);
        } else if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Le formulaire contiens des erreurs, veuillez les corriger.');
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
            'form' => $form
        ]);
    }
}
