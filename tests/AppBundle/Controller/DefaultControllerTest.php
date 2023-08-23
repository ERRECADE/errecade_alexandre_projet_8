<?php

namespace App\Tests\AppBundle\Controller;

use App\Tests\UserConnectAbstract;


class DefaultControllerTest extends UserConnectAbstract
{
    public function testIndex()
    {
        $client = $this->UserLogged();
        
        $locationHeader = $client->getResponse()->headers->getCookies('flat');
        static::assertEquals($locationHeader[0]->getPath(), '/');
        static::assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $client->getCrawler()->filter('h1'));
    }
}
