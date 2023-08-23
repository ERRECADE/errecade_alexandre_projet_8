<?php

namespace Tests\AppBundle\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
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
    
}

public function testEditAction()
{
    $client = $this->UserLogged();
    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $user = $client->getContainer()->get('security.token_storage')->getToken()->getUser();

    $taskRepository = $entityManager->getRepository(Task::class);
    $existingTasks = $taskRepository->findBy(['user' => $user], null, 1);
    $existingTask = reset($existingTasks);
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
}
public function testDeleteTaskUnauthorized()
{
    $client = static::createClient();
    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $existingTasks = $entityManager->getRepository(Task::class)->findBy([], null, 1);
    $existingTask = reset($existingTasks); 

    $url = '/tasks/' . $existingTask->getId() . '/delete';
    $client->request('DELETE', $url);
    static::assertEquals(302, $client->getResponse()->getStatusCode());
}
public function testDeleteTaskAsAdmin()
{
    $client = $this->UserLogged();
    
    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $existingTasks = $entityManager->getRepository(Task::class)->findBy([], null, 1);
    $existingTask = reset($existingTasks); 
    $taskId = $existingTask->getId();
    $url = '/tasks/' . $taskId . '/delete';
    $client->request('DELETE', $url);

    static::assertEquals(302, $client->getResponse()->getStatusCode());
    $deletedTask = $entityManager->getRepository(Task::class)->find($taskId);
    static::assertNull($deletedTask, 'La tâche a été supprimée correctement.');
}

public function testDeleteTaskCreatedByUser()
{
    $client = $this->UserLoggedUser();

    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $user = $client->getContainer()->get('security.token_storage')->getToken()->getUser();

    $ownedTask = $entityManager->getRepository(Task::class)->findOneBy(['user' => $user]);


    $taskId = $ownedTask->getId();
    $url = '/tasks/' . $taskId . '/delete';
    $client->request('DELETE', $url);

    static::assertEquals(302, $client->getResponse()->getStatusCode());
    $deletedTask = $entityManager->getRepository(Task::class)->find($taskId);
    static::assertNull($deletedTask, 'La tâche a été supprimée correctement.');
}

public function testDeleteTaskNotOwnedByUser()
{
    $client = $this->UserLoggedUser();
    $entityManager = $client->getContainer()->get('doctrine')->getManager();
    $existingTasks = $entityManager->getRepository(Task::class)->findBy([], null, 1);
    $existingTask = reset($existingTasks); 
    $taskId = $existingTask->getId();
    $url = '/tasks/' . $taskId . '/delete';
    $client->request('DELETE', $url);

    static::assertEquals(403, $client->getResponse()->getStatusCode());
}


}
