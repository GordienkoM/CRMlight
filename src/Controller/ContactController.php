<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * Show the contact book page
     * 
     * @Route("/", name="contact_index", methods={"GET"})
     */ 
    public function index(ContactRepository $contactRepository, CategoryRepository $categoryRepository): Response
    {
        $contacts = $contactRepository->findBy(
            ['enable' => 'true'],
            ['lastname' => 'ASC']
        );

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'categories' => $categoryRepository->findAll()
        ]);
    }


    /**
     * Show the contact book page
     * 
     * @Route("/category/{id}", name="contact_category", methods={"GET"})
     */ 
    public function contacts($id, ContactRepository $contactRepository, CategoryRepository $categoryRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
       
        $contacts = [];
        $contactIds = $entityManager->getConnection()->fetchAllAssociative(     
            'SELECT c.id FROM contact c 
            INNER JOIN contact_category cc ON c.id=cc.contact_id
            INNER JOIN category cat ON cat.id=cc.category_id
            WHERE cc.category_id=:id',
            ['id' => $id] 
        );  
        foreach ($contactIds as $contactId) {
            $contact = $contactRepository->findOneBy(['id'=>$contactId]);
            array_push($contacts, $contact);
        } 


        // $contacts = $contactRepository->findBy(
        //     ['enable' => 'true'],
        //     ['lastname' => 'ASC'],
        //     ['category' => $id],
        // );

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'categories' => $categoryRepository->findAll()
        ]);
    }


    /**
     * @Route("/new", name="contact_new", methods={"GET", "POST"})
     */


    public function new(Request $request,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $contact = new Contact();
        // connected in user
        $user = $this->getUser();
        $contact->setCreator($user);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contact $contact,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contact,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
