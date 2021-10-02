<?php

namespace App\Controller;

use App\Entity\Sandbox;
use App\Form\SandboxType;
use App\Repository\SandboxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sandbox")
 */
class SandboxController extends AbstractController
{
    /**
     * @Route("/", name="sandbox_index", methods={"GET"})
     */
    public function index(SandboxRepository $sandboxRepository): Response
    {
        return $this->render('sandbox/index.html.twig', [
            'sandboxes' => $sandboxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sandbox_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sandbox = new Sandbox();
        $form = $this->createForm(SandboxType::class, $sandbox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($request->query);
            dump($request->request);
            dump($request->request->all());
            dump($request->query->all());
            dump($request->server);
            dump($request->cookies);
            dump($request->files);
            dump($request->headers);
            die();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sandbox);
            $entityManager->flush();

            return $this->redirectToRoute('sandbox_index');
        }

        return $this->render('sandbox/new.html.twig', [
            'sandbox' => $sandbox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edition-form", name="app_edit_form")
     */
    public function editSandbox(Request $request): Response
    {
        $form = $this->createForm(SandboxType::class, null);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // $this->getDoctrine()->getManager()->flush();
            die('ok');
            return $this->redirectToRoute('app_index');
        }
        // else{
        //     dump($form->getErrors(true)); 

        //     foreach ($form->getErrors() as $oneError) {
        //         dump($oneError);
        //     }

        //     die();
        // }
        return $this->render('sandbox/edit-sandbox.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
