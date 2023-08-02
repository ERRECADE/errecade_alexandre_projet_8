<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Tests\UserConnectAbstract;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserControllerTest  extends UserConnectAbstract
{
    public function testListAction()
    {
        $client = $this->UserLogged();
        $crawler = $client->request('GET', '/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $usersCount = $crawler->filter('.table')->count();
        $this->assertGreaterThan(0, $usersCount);
    }

    public function testUserCreate()
    {
        $client = $this->UserLogged();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $crawler = $client->request('GET', '/users/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $uniqueUsername = 'testUser_' . uniqid();
        $uniqueEmail = uniqid() . '@example.com';
    
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => $uniqueUsername,
            'user[password][first]' => 'password123',
            'user[password][second]' => 'password123',
            'user[email]' => $uniqueEmail,
        ]);
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('/users', $client->getRequest()->getPathInfo());

    }

    public function testUserEdit()
    {
        $client = $this->UserLogged();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $existingUser = $entityManager->getRepository(User::class)->findOneBy([]);
    
        $this->assertNotNull($existingUser, 'Aucune tâche trouvée dans la base de données pour le test.');
    
        $UserId = $existingUser->getId();
        $url = '/users/' . $UserId . '/edit';
    
        $crawler = $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $uniqueEmail = $existingUser->getEmail();

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'je change',
            'user[password][first]' => 'password123',
            'user[password][second]' => 'password123',
            'user[email]' => $uniqueEmail,
        ]);
    
        $crawler = $client->submit($form);
    
        $this->assertTrue($client->getResponse()->isRedirect('/users'));

        $crawler = $client->followRedirect();

        $updatedUser = $entityManager->getRepository(User::class)->find($UserId);
        $this->assertEquals('je change', $updatedUser->getUsername());
        $this->assertEquals($uniqueEmail, $updatedUser->getEmail());
    }
    


}