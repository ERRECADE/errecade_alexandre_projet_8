<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Tests\UserConnectAbstract;

class DefaultControllerTest extends UserConnectAbstract
{
    public function testIndex()
    {
        $client = $this->UserLogged();
        
        $locationHeader = $client->getResponse()->headers->getCookies('flat');
        $this->assertEquals($locationHeader[0]->getPath(), '/');
        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $client->getCrawler()->filter('h1')->text());
    }
}
