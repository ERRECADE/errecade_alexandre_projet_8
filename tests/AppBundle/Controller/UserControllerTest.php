<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use App\Tests\UserConnectAbstract;
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

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $usersCount = $crawler->filter('.table')->count();
        static::assertGreaterThan(0, $usersCount);
    }

    public function testUserCreate()
    {
        $client = $this->UserLogged();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $crawler = $client->request('GET', '/users/create');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        $uniqueUsername = 'testUser_' . uniqid();
        $uniqueEmail = uniqid() . '@example.com';
    
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => $uniqueUsername,
            'user[password][first]' => 'password123',
            'user[password][second]' => 'password123',
            'user[email]' => $uniqueEmail,
        ]);
        $client->submit($form);
        static::assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();
        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals('/users', $client->getRequest()->getPathInfo());

    }

    public function testUserEdit()
    {
        $client = $this->UserLogged();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $existingUser = $entityManager->getRepository(User::class)->findOneBy([]);
    
        static::assertNotNull($existingUser, 'Aucune tâche trouvée dans la base de données pour le test.');
    
        $UserId = $existingUser->getId();
        $url = '/users/' . $UserId . '/edit';
    
        $crawler = $client->request('GET', $url);

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $uniqueEmail = $existingUser->getEmail();

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'je change',
            'user[password][first]' => 'password123',
            'user[password][second]' => 'password123',
            'user[email]' => $uniqueEmail,
        ]);
    
        $crawler = $client->submit($form);
    
        static::assertTrue($client->getResponse()->isRedirect('/users'));

        $crawler = $client->followRedirect();

        $updatedUser = $entityManager->getRepository(User::class)->find($UserId);
        static::assertEquals('je change', $updatedUser->getUsername());
        static::assertEquals($uniqueEmail, $updatedUser->getEmail());
    }
    


}