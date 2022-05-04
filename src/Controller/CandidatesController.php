<?php

namespace App\Controller;

use App\Entity\Candidates;
use App\Entity\Candidature;
use App\Entity\InfoAdminCandidate;
use App\Form\CandidatesType;
use App\Form\ChangePasswordFormType;
use App\Form\ExperienceType;
use App\Form\InfoAdminCandidateType;
use App\Form\JobCategoryType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\CandidatesRepository;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidates')]
class CandidatesController extends AbstractController
{
    #[Route('/', name: 'candidates_index', methods: ['GET'])]
    public function index(CandidatesRepository $candidatesRepository): Response
    {
        return $this->render('candidates/index.html.twig', [
            'candidates' => $candidatesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'candidates_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $candidate = new Candidates();
        $form = $this->createForm(CandidatesType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidate);
            $entityManager->flush();

            return $this->redirectToRoute('candidates_index');
        }

        return $this->render('candidates/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'candidates_show', methods: ['GET'])]
    public function show(Candidates $candidate): Response
    {
        // dd($candidate);
        return $this->render('candidates/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/{id}/edit', name: 'candidates_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidates $candidate): Response
    {

        $CANDIDATE = [
            'Candidate'   => $candidate,
            'InfoAdmin'   => $candidate->getAdminInfo(),
            'Password'    => $this->getUser()
        ];

        if ($this->getUser()->getRoles()[0] === "ROLE_ADMIN") {
            $form = $this->createFormBuilder($CANDIDATE)
                ->add('Candidate', CandidatesType::class)
                ->add('InfoAdmin', InfoAdminCandidateType::class)
                ->getForm();
        }else {
            $form = $this->createForm(CandidatesType::class, $candidate);
            $form2 = $this->createForm(ChangePasswordFormType::class, $this->getUser());
        }

        $array = (array) $form->getData();
        $i = 0;
        $total = 0;
        foreach ($array as $key => $value) {
            if ($value !== null){
                $total++;
                $i++;
            }else{
                $total++;
            }
        }
        $pourcentage =  $i/$total*100;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd(round($pourcentage), $i ,$total, $candidate);
            if ($pourcentage >= 86) {
                $candidate->setAvailability(true);
            }

            //Upload Image
            $this->fileTraitement($form['cv'],$candidate);
            $this->fileTraitement($form['passport'],$candidate);
            $this->fileTraitement($form['profilPicture'],$candidate);


            if ($this->getUser()->getRoles()[0] === "ROLE_ADMIN") {

                $filesAdmin = $form['InfoAdmin']['files']->getData();

                $filePath = [];
                foreach ($filesAdmin as $file) {
                    array_push($filePath, $file->getClientOriginalName());
                }
                $candidate->getAdminInfo()->setFiles(array($filePath));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidate);
            $entityManager->flush();

            $this->addFlash(
                '	type',
                '	Uptated Success!!'
            );
            if ($this->getUser()->getRoles()[0] === "ROLE_ADMIN") {
                return $this->redirectToRoute('admin_candidates',[

                ]);
            }else {
                return $this->redirectToRoute('candidates_edit',[
                    'id' => $candidate->getId()
                ]);
            }
        }


        return $this->render('candidates/edit.html.twig', [
            'candidate' => $candidate,
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'pourcentage' => round($pourcentage)
        ]);
    }

    #[Route('/{id}', name: 'candidates_delete', methods: ['DELETE'])]
    public function delete(Request $request, Candidates $candidate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('candidates_index');
    }

    public function fileTraitement($file,$candidate)
    {

        $content = $file->getData();
        if($content !== null){
            $this->uploadFile($content);
            $filePath = $content->getClientOriginalName();
            if($file->getName() == 'cv'){
                $candidate->setCv($filePath);
            }else if ($file->getName() == 'passport'){
                $candidate->setPassport($filePath);
            }else if ($file->getName() == 'profilPicture'){
                $candidate->setProfilPicture($filePath);
            }else{
                return null;
            }

        }
    }
    public function uploadFile($fileData)
    {
        // On génère un nouveau nom de fichier
        $fichier = $fileData->getClientOriginalName();

        // On copie le fichier dans le dossier uploads
        $fileData->move(
            $this->getParameter('images_directory'),
            $fichier
        );
        return $fichier;
    }
//    /**
//     * @Route("/candidature/{id}", name="candidates_candidatures", methods={"GET"})
//     */
//    public function candidates_candidatures(Candidates $candidate, CandidatureRepository $CandidaturesRepository): Response
//    {
//        $candidature = $CandidaturesRepository->getAllByCandidate($candidate);
//
//        // dd($candidature);
//        return $this->render('candidates/candidature.html.twig', [
//            'candidate' => $candidate,
//            'candidatures' => $candidature
//        ]);
//    }
}