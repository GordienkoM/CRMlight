<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ContactRepository $contactRepository, EventRepository $eventRepository ): Response
    {
        //redirect user non connected
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $contacts = $contactRepository->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->execute();

        // $contacts = $contactRepository->findAll();
        return $this->render('main/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

}
