<?php

namespace App\Controller;

use App\Form\ModuleType;

use App\Entity\FormationModule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="index_module")
     */
    public function index(ManagerRegistry $doctrine): Response
        {
        $modules = $doctrine->getRepository(FormationModule::class)->findAll();
        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }
          /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/update/{id}", name="update_module")
     */
    public function add(ManagerRegistry $doctrine, FormationModule $module = null, Request $request): Response{

        if(!$module){
            $module = new FormationModule();
        }
        
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $module = $form->getData();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('index_module');
        }

        return $this->render('module/add.html.twig', [
            'formModule' => $form->createView()
            
        ]);
    }
    
    /**
     * @route("/module/{id}", name="show_module")
     */
    public function show(FormationModule $modules): Response{

        return $this->render('module/show.html.twig', [
            'modules' => $modules,
        ]);
    }

}
