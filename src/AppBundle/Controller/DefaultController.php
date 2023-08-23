<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
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
