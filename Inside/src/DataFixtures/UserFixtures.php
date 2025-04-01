<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Enums\Allergy;
use App\Enums\Diet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties] class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['email' => 'user1@example.com', 'name' => 'Alice Johnson', 'roles' => ['ROLE_USER'], 'diet' => Diet::VEGETARIEN, 'allergy' => [Allergy::FRUIT_A_COQUE]],
            ['email' => 'user2@example.com', 'name' => 'Bob Smith', 'roles' => ['ROLE_ADMIN'], 'diet' => Diet::VEGAN, 'allergy' => [Allergy::LACTOSE]],
            ['email' => 'user3@example.com', 'name' => 'Charlie Brown', 'roles' => ['ROLE_USER'], 'diet' => null, 'allergy' => []],
            ['email' => 'user4@example.com', 'name' => 'Diana Prince', 'roles' => ['ROLE_USER'], 'diet' => Diet::VEGETARIEN, 'allergy' => [Allergy::GLUTEN]],
            ['email' => 'user5@example.com', 'name' => 'Evan Peters', 'roles' => ['ROLE_USER'], 'diet' => Diet::VEGAN, 'allergy' => [Allergy::FRUIT_A_COQUE, Allergy::LACTOSE]],
        ];

        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles($data['roles']);
            $user->setName($data['name']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password')); //même mot de passe pour tout le monde
            $user->setDiet($data['diet']);
            $user->setAllergy($data['allergy']);

            $manager->persist($user);
        }

        $manager->flush();
    }


}
