<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_users")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="admin_contacts")
     */
    public function contacts(ContactRepository $contactRepository): Response
    {
        return $this->render('admin/contacts.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }
}
