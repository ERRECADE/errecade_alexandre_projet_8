<?php

namespace  App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


abstract class UserConnectAbstract extends WebTestCase
{
    public function UserLogged()
    {
        $client = static::createClient();

        //trouver la version login uSER pour les test en symfony 
        $crawler = $client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerNode->form([
            '_username' => 'test1@test.fr',
            '_password' => '1234'
        ]);

        $client->submit($form);
        //var_dump($form);
        // dd();
        $client->followRedirect();
        
        static::assertEquals(200, $client->getResponse()->getStatusCode());

        return $client;
    }
}
