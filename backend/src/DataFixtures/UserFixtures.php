<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Operation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer un utilisateur de test
        $user = new User();
        $user->setEmail('john@example.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword('password123');
        $manager->persist($user);

        // Créer des catégories
        $categories = [
            ['Food', '#59E5A9'],
            ['Transport', '#FCA311'],
            ['Entertainment', '#EC0B43']
        ];

        $categoryObjects = [];
        foreach ($categories as [$title, $color]) {
            $category = new Category();
            $category->setTitle($title);
            $category->setColor($color);
            $category->setUser($user);
            $manager->persist($category);
            $categoryObjects[] = $category;
        }

        // Créer des opérations
        $operations = [
            ['Grocery shopping', 45.50, '2024-01-15'],
            ['Bus ticket', 12.00, '2024-01-14'],
            ['Movie theater', 25.00, '2024-01-13']
        ];

        foreach ($operations as $index => [$label, $amount, $date]) {
            $operation = new Operation();
            $operation->setLabel($label);
            $operation->setAmount($amount);
            $operation->setDate(new \DateTime($date));
            $operation->setUser($user);
            $operation->setCategory($categoryObjects[$index]);
            $manager->persist($operation);
        }

        $manager->flush();
    }
}