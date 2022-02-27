<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setFirstName("User");
        $user->setLastName("User");
        $user->setEmail("user@bookstore.com");
        $user->setPassword($this->hasher->hashPassword(    $user, 'user'));
        $manager->persist($user);

        $admin = new User();
        $admin->setFirstName("admin");
        $admin->setLastName("admin");
        $admin->setEmail("admin@bookstore.com");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        $roman = new Category();
        $roman->setName("Roman");
        $roman->setDescription("Un roman est un livre en prose.");
        $manager->persist($roman);

        $poesie = new Category();
        $poesie->setName("Poésie");
        $poesie->setDescription("Un poeme est un text écrit avec des ryhmes.");
        $manager->persist($poesie);

        $balto = new Product();
        $balto->setName("Balto");
        $balto->setAvailable(true);
        $balto->setDescription("Le Cid est écrit par Pière Corneille");
        $balto->setPrice(33);
        $balto->setCategory($roman);
        $manager->persist(($balto));

        $cid = new Product();
        $cid->setName("Le Cid");
        $cid->setAvailable(true);
        $cid->setDescription("Le Cid est écrit par Pière Corneille");
        $cid->setPrice(22);
        $cid->setCategory($poesie);
        $manager->persist(($cid));

        $manager->flush();
    }
}
