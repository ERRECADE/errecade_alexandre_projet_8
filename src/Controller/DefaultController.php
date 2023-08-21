<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DefaultController extends AbstractController
{ 

    #[Route('/', name: 'homepage')]
    // #[IsGranted('view')]
    public function indexAction()
    {
        // add sur function souhaitez
        // if ($this->container->has('debug.stopwatch')) {
        //     $stopwatch = $this->get('debug.stopwatch');

        //     $stopwatch->start('sleep action');
        //     sleep(5);
        //     $stopwatch->stop('sleep action');
        // }
        return $this->render('default/index.html.twig');
    }
}
