<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Message\MailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Sandbox;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Process\Process;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function indexAction()
    {
        $sandbox = new Sandbox();
        $sandbox->setName('iss936');

        return $this->render('sandbox-twig.html.twig', [
            'username' => 'iss936',
            'sandbox' => $sandbox
        ]);
        // return $this->render('@admin/dashboard.html.twig');
    }

    /**
     * @Route("/messenger-home", name="app_messenger_home")
     */
    public function messengerHomeAction(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $task = new Incident();
        $task->setUser($this->getUser())
             ->setCreatedAt(new \DateTime());

        $form = $this->createForm(IncidentType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $this->dispatchMessage(new MailNotification($task->getDescription(), $task->getId(), $task->getUser()->getEmail()));

            return $this->redirectToRoute('app_index');
        }

        return $this->render('home-messenger.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/detail-product/{id}/{cat}", name="app_detail_product")
     */
    public function detailProduct($id, $cat)
    {
        return $this->render('detail_product.html.twig');
    }

    public function recentArticles(int $max = 3): Response
    {
        // get the recent articles somehow (e.g. making a database query)
        $articles = [1, 2, 3];

        return $this->render('blog/_recent_articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/loop-twig", name="app_loop_twig")
     */
    public function loopTwig()
    {
        return $this->render('loop.html.twig', [
            'iss936' => 'bonjour iss936'
        ]);
    }

     /**
     * @Route("/download-pj", name="app_download_pj")
     */
    public function downloadPj()
    {
        // load the file from the filesystem
        $file = new File('maquettes.pdf');

        return $this->file($file, 'my_invoice.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }


    /**
     * @Route("/modules/test/{id?}", name="app_module_test")
     */
    public function issa(?int $id = 1) {
        dump($id);
        die('oui');
    }

    /**
     * This route has a greedy pattern and is defined first.
     *
     * @Route("/portail/{slug}", name="blog_show")
     */
    public function show(string $slug)
    {
        die('show');
    }

    /**
     * This route could not be matched without defining a higher priority than 0.
     *
     * @Route("/portail/list", name="blog_list", priority=2)
     */
    public function list()
    {
        die('list');
    }

    /**
     * @Route(
     *     "/articles/{_locale}/search.{_format}",
     *     locale="en",
     *     format="html",
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|xml",
     *         "_fragment": "issa|idr",
     *     }
     * )
     */
    public function search($_locale,$_format): Response
    {
        dump($_locale);
        dump($_format);
        die('ok');
    }

}
