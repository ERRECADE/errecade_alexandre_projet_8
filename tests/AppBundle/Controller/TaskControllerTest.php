<?php

namespace Tests\AppBundle\Controller;

use App\Entity\Task;
use App\Tests\UserConnectAbstract;


class TaskControllerTest extends UserConnectAbstract
{
    public function testTask() : void
{
    $client = $this->UserLogged();
    
    $locationHeader = $client->getResponse()->headers->getCookies('flat');
    $link = $client->getCrawler()->selectLink('Créer une nouvelle tâche');
    $crawler = $client->click($link->link());

    static::assertEquals(200, $client->getResponse()->getStatusCode());
    static::assertEquals('/tasks/create', $client->getRequest()->getPathInfo());


}

public function testTaskCreate() : void
{
    $client = $this->UserLogged();

    $locationHeader = $client->getResponse()->headers->getCookies('flat');
    $link = $client->getCrawler()->selectLink('Créer une nouvelle tâche');
    $crawler = $client->click($link->link());

    $locationHeader = $client->getResponse()->headers->getCookies('flat');
    $buttonCrawlerNode = $crawler->selectButton('Ajouter');
    $form = $buttonCrawlerNode->form();
    $form = $buttonCrawlerNode->form([
        'task[title]' => 'testAlex',
        'task[content]' => 'test'
    ]);
    $client->submit($form);
    $client->followRedirect();
    
    static::assertEquals(200, $client->getResponse()->getStatusCode());
    static::assertEquals('/tasks', $client->getRequest()->getPathInfo());
}

public function testTaskDelete() : void
{
    $client = $this->UserLogged();

    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $task = new Task();
    $task->setTitle('Titre de la tâche delete');
    $task->setContent('Contenu de la tâche delete');
    $entityManager->persist($task);
    $entityManager->flush();

    $taskId = $task->getId();
    $url = '/tasks/' . $taskId . '/delete';

    $crawler = $client->request('GET', $url);
    static::assertTrue($client->getResponse()->isRedirect('/tasks'));

    $deletedTask = $entityManager->getRepository(Task::class)->find($taskId);
    static::assertNull($deletedTask);

    $crawler = $client->request('GET', '/tasks');
}

public function testToggleTaskAction() : void
{
    $client = $this->UserLogged();

    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $task = new Task();

    $task->setTitle('Titre de la tâche');
    $task->setContent('Contenu de la tâche');
    $task->isIsDone(); 
    $entityManager->persist($task);
    $entityManager->flush();

    $taskId = $task->getId();
    $url = '/tasks/' . $taskId . '/toggle';

    $crawler = $client->request('GET', $url);
    static::assertTrue($client->getResponse()->isRedirect('/tasks'));

    $updatedTask = $entityManager->getRepository(Task::class)->find($taskId);
    static::assertTrue($updatedTask->isIsDone(true)); 

    // $flashMessages = $client->getContainer()->get('session')->getFlashBag()->get('success');
    // static::assertNotEmpty($flashMessages); 
    // static::assertEquals(sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()), $flashMessages[0]);

    
}

public function testEditAction()
{
    $client = $this->UserLogged();
    $entityManager = $client->getContainer()->get('doctrine')->getManager();

    $existingTask = $entityManager->getRepository(Task::class)->findOneBy([]);

    static::assertNotNull($existingTask, 'Aucune tâche trouvée dans la base de données pour le test.');

    $taskId = $existingTask->getId();
    $url = '/tasks/' . $taskId . '/edit';

    $crawler = $client->request('GET', $url);

    static::assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Modifier')->form([
        'task[title]' => 'Nouveau titre de la tâche',
        'task[content]' => 'Nouveau contenu de la tâche',
    ]);

    $crawler = $client->submit($form);

    static::assertTrue($client->getResponse()->isRedirect('/tasks'));

    $updatedTask = $entityManager->getRepository(Task::class)->find($taskId);
    static::assertEquals('Nouveau titre de la tâche', $updatedTask->getTitle());
    static::assertEquals('Nouveau contenu de la tâche', $updatedTask->getContent());

    // $flashMessages = $client->getContainer()->get('session')->getFlashBag()->get('success');
    // static::assertNotEmpty($flashMessages);
    // static::assertEquals('La tâche a bien été modifiée.', $flashMessages[0]);
}


}
