<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SystemController extends AbstractController
{
    /**
     * @Route("/system/filesystem", name="app_system_filesystem")
     * @param Security $security
     * @return Response
     */
    public function index(): Response
    {
    	$em = $this->getDoctrine()->getManager();
        $fs = new Filesystem();
        try {
//            $fs->mkdir(['/var/www/html/current/issasama', '/var/www/html/current/kakarot'], 0777);
//            $exist = $fs->exists(['/var/www/html/current/issasama', '/var/www/html/current/kakarots']);
//            $exist = $fs->copy('/var/www/html/current/issa.txt', '/var/www/html/current/idr.txt', true);
//            $targetLink = $fs->readLink('/var/www/html/current/link-sym.txt', true);
            $fs->appendToFile('/var/www/html/current/kak.txt', 'Hello World');
//            dump($targetLink);
            die('ok');
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }
    }
}
