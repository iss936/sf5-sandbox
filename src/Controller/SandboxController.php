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
     * @Route("/{id}", name="sandbox_show", methods={"GET"})
     */
    public function show(Sandbox $sandbox): Response
    {
        return $this->render('sandbox/show.html.twig', [
            'sandbox' => $sandbox,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sandbox_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sandbox $sandbox): Response
    {
        $form = $this->createForm(SandboxType::class, $sandbox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sandbox_index');
        }

        return $this->render('sandbox/edit.html.twig', [
            'sandbox' => $sandbox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sandbox_delete", methods={"POST"})
     */
    public function delete(Request $request, Sandbox $sandbox): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sandbox->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sandbox);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sandbox_index');
    }
}
