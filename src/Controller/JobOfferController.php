<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\CandidatureRepository;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/job_offers")]
class JobOfferController extends AbstractController
{
    #[Route('/', name: 'job_offer_index', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository, CandidatureRepository $candidatureRepository): Response
    {
        $jobOffers = $jobOfferRepository->getAllJobOffer();
        if ( $this->getUser() == null) {

            return $this->render('job_offer/index.html.twig', [
                'job_offers' => $jobOffers,
                'candidate' => null,
                'isCandidates' =>null
            ]);

        }else{
            $isCandidate = $candidatureRepository->getAllByCandidate($this->getUser()->getCandidate());
            return $this->render('job_offer/index.html.twig', [
                'job_offers' => $jobOffers,
                'candidate' => $this->getUser()->getCandidate(),
                'isCandidates' =>$isCandidate
            ]);
        }
    }

    #[Route('/new', name: 'job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $candidate = $this  ->getDoctrine()
            ->getRepository(Candidates::class)
            ->findOneBy(array('user' => $this->getUser()));

        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {




            $date = new \DateTime('@'.strtotime('now + 2 hour'));
            $jobOffer->setCreatedAt($date);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_job_offers');
        }

        return $this->render('job_offer/new.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form->createView(),
            'candidate' => $candidate,
        ]);
    }


    #[Route('/{id}', name: 'job_offer_show',  methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        if ( $this->getUser() == null ) {
            return $this->render('job_offer/index.html.twig', [
                'candidate' => null,
                'job_offer' => $jobOffer
            ]);
        }
    }
}
