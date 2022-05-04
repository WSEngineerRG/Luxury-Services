<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    # @isGranted('ROLE_ADMIN')
    #[Route('/admin', name: 'app_admin')]
    public function index(JobOfferRepository $jobOfferRepository, CustomerRepository $clientRepository, EntityManagerInterface $doctrine): Response
    {
        $user = $doctrine->getRepository(User::class);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $this->getUser(),
            'users' => $user->findAll(),
            'job_offers' => $jobOfferRepository->findAll(),
            'customers' => $clientRepository->findAll(),
        ]);
    }

    // New Customer

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/new/', name: 'app_admin_new_customer')]
    public function new(Request $request, ManagerRegistry $doctrine): Response //NEW CUSTOMER
    {
        $client = new Customer();
        $date = new \DateTime();
        $client-> setCreatedAt($date);
        $form = $this->createForm(Customer::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/NewCustomer.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    //NEW JOB OFFER

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/offer/new', name: 'app_admin_new_offer')]
    public function newOffer(Request $request, ManagerRegistry $doctrine): Response //NEW CUSTOMER
    {
        $jobOffer = new JobOffer();
        $date = new \DateTime();
        $jobOffer-> setCreatedAt($date);
        $form = $this->createForm(JobOffer::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }
    }

    // Delete Customer

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/delete/{id}', name: 'app_admin_delete_customer')]
    public function delete(Customer $client, EntityManagerInterface $entityManager): Response //DELETE CUSTOMER
    {
        $entityManager->remove($client);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    // Delete Offer

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/delete/{id}', name: 'app_admin_delete_offer')]
    public function deleteOffer(JobOffer $jobOffer, EntityManagerInterface $entityManager): Response //DELETE CUSTOMER
    {
        $entityManager->remove($jobOffer);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    // EDIT CUSTOMER

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/edit/{id}', name: 'app_admin_edit_customer')]
    public function editCustomer(Customer $client, Request $request, ManagerRegistry $doctrine): Response //EDIT CUSTOMER
    {
        $form = $this->createForm(Customer::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/EditCustomer.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    // EDIT OFFER

    # @isGranted('ROLE_ADMIN')
    #[Route('/admin/edit/{id}', name: 'app_admin_edit_offer')]
    public function editOffer(JobOffer $jobOffer, Request $request, ManagerRegistry $doctrine): Response //EDIT CUSTOMER
    {
        $form = $this->createForm(JobOffer::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/EditOffer.html.twig', [
            'jobOffer' => $jobOffer,
            'form' => $form->createView(),
        ]);
    }

}