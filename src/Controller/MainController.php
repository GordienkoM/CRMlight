<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findLastContacts();
        return $this->render('main/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

}
