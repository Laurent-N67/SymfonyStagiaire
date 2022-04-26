<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Planifier;
use App\Entity\Stagiaire;
use App\Form\SessionsType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SessionsController extends AbstractController
{
    /**
     * @Route("/sessions", name="index_sessions")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();

        return $this->render('sessions/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
    /**
     * @Route("/sessions/add", name="add_sessions")
     * @Route("/sessions/update/{id}", name="update_sessions")
     */
    public function add(ManagerRegistry $doctrine, Session $sessions = null, Request $request): Response{

        if(!$sessions){
            $sessions = new Session();
        }
        
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SessionsType::class, $sessions);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $sessions = $form->getData();
            $entityManager->persist($sessions);
            $entityManager->flush();

            return $this->redirectToRoute('index_sessions');
        }

        return $this->render('sessions/add.html.twig', [
            'formSessions' => $form->createView(),
            'title' => "Ajouter",
            'sessionId'=>$sessions->getId(), 
            
        ]);
    }
    /**
     * @Route("/sessions/delete/{id}", name="delete_sessions")
     */
    public function delete(ManagerRegistry $doctrine, Session $sessions){

        $entityManager = $doctrine->getManager();
        $entityManager->remove($sessions);
        $entityManager ->flush();
        return $this->redirectToRoute("index_sessions");
    }
    /**
     * @route("/sessions/{id}", name="show_sessions")
     */
    public function show(SessionRepository $sr, Session $sessions): Response{

        $nonInscrits = $sr->getNonIscrits($sessions->getId());

        return $this->render('sessions/show.html.twig', [
            'sessions' => $sessions,
            'nonInscrits' => $nonInscrits
        ]);
    }

    /**
     * @Route("/session/{idSession}/addStagiaire/{idStagiaire}", name="addStagiaire_session")
     * @ParamConverter("session", options={"mapping": {"idSession": "id"}})
     * @ParamConverter("stagiaire", options={"mapping":{"idStagiaire": "id"}})
     */
    public function addInscription(ManagerRegistry $doctrine, Stagiaire $stagiaire, Session $session){
        
        $entityManager = $doctrine ->getManager();
        $session->addInscription($stagiaire);
        $entityManager->flush();
        $stagiaireNonInscrits = $doctrine->getRepository(Session::class)->getNonIscrits($session->getId()); 

        return $this->render('sessions/show.html.twig',[
            'sessions' =>$session,
            'nonInscrits'=>$stagiaireNonInscrits
        ]);
    }
    /**
     * @Route("/session/{idSession}/removeStagiaire/{idStagiaire}", name="removeStagiaire_session")
     * @ParamConverter("session", options={"mapping": {"idSession": "id"}})
     * @ParamConverter("stagiaire", options={"mapping":{"idStagiaire": "id"}})
     */
    public function removeInscription(ManagerRegistry $doctrine, Stagiaire $stagiaire, Session $session){
        
        $entityManager = $doctrine ->getManager();
        $session->removeInscription($stagiaire);
        $entityManager->flush();
        $stagiaireNonInscrits = $doctrine->getRepository(Session::class)->getNonIscrits($session->getId()); 

        return $this->render('sessions/show.html.twig',[
            'sessions' =>$session,
            'nonInscrits'=>$stagiaireNonInscrits
        ]);
    }
    /**
     * @Route("/session{idSession}/removePlanifier/{idPlanifier}", name="removePlanifier_session")
     * @ParamConverter("session", options={"mapping": {"idSession":"id"}})
     * @ParamConverter("planifier",options={"mapping":{"idStagiaire":"id"}})
     */
    public function removePlanifier(ManagerRegistry $doctrine, Planifier $planifier, Session $session){
        
        $entityManager = $doctrine ->getManager();
        $session->removePlanifier($planifier);
        $entityManager->flush();
        $planifierNonInscrits = $doctrine->getRepository(Session::class)->getNonPlanifier($session->getId());

        return $this->render('sessions/show.html.twig',[
            'sessions'=>$session,
            'nonPlanifier'=>$planifierNonInscrits
        ]);
    }
}      
