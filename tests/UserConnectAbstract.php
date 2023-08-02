<?php

namespace Tests;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class UserConnectAbstract extends WebTestCase
{
    public function UserLogged()
    {
        $client = static::createClient();
       

        $crawler = $client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form([
            '_username' => 'testAlex',
            '_password' => 'test'
        ]);

        $client->submit($form);
        $client->followRedirect();
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return $client;
    }
}
