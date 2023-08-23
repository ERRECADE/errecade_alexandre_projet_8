<?php

namespace App\DataFixtures;


use DateTime;
use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $adminUsers = [];
        $userUsers = [];
        for ($i = 0; $i < 1; $i++) {
            $admin = new User();
            $admin->setUsername('Admin ' . $i);
            $admin->setEmail('admin' . $i .'@test.fr');
            $admin->setPassword($this->userPasswordHasher->hashPassword($admin, "test"));
            $admin->setRoles(["ROLE_ADMIN"]);
            $manager->persist($admin);
            $adminUsers[] = $admin;
        }
        
        for ($i = 0; $i < 1; $i++) {
            $user = new User();
            $user->setUsername('User ' . $i);
            $user->setEmail('user' . $i .'@test.fr');
            $user->setPassword($this->userPasswordHasher->hashPassword($user, "test"));
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $userUsers[] = $user;
        }


        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle('Task ' . $i);
            $task->setContent('voila une description');
            if ($i % 3 === 0) {
                $task->setUser(null);
            } else {
                if ($i % 2 === 0) {
                    $task->setUser($adminUsers[0]);
                } else {
                    $task->setUser($userUsers[0]);
                }
            }
            
            $manager->persist($task);
        }

        $manager->flush();
    }
}