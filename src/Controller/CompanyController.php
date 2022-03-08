<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="company_index", methods={"GET"})
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        $companies = $companyRepository->findBy(
            ['enable' => 'true'],
            ['name' => 'ASC']
        );

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/new", name="company_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $company = new Company();
        // connected in user
        $user = $this->getUser();
        $company->setCreator($user);

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="company_show", methods={"GET"})
     */
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="company_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Company $company, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="company_delete", methods={"POST"})
     */
    public function delete(Request $request, Company $company, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
    }
}
