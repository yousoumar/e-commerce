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
        $admin = new User();
        $admin->setFirstName("Admin");
        $admin->setLastName("Admin");
        $admin->setEmail("admin@bookstore.com");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setAddress("1 rue du Faubourg");
        $admin->setCity("Paris");
        $admin->setCountry("France");
        $manager->persist($admin);

        $user = new User();
        $user->setFirstName("Anne");
        $user->setLastName("Claire");
        $user->setEmail("anne@bookstore.com");
        $user->setPassword($this->hasher->hashPassword( $user, 'anne'));
        $user->setAddress("1 rue du Faubourg");
        $user->setCity("Parma");
        $user->setCountry("Italy");
        $manager->persist($user);



        $novel = new Category();
        $novel->setName("Novel");
        $novel->setDescription("An invented prose narrative that is usually long and complex and deals especially with human experience through a usually connected sequence of events.");
        $novel->setImgUrl("https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8Ym9va3xlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60");
        $manager->persist($novel);

        $poetry = new Category();
        $poetry->setName("Poetry");
        $poetry->setDescription("Literary work in which the expression of feelings and ideas is given intensity by the use of distinctive style and rhythm; poems collectively or as a genre of literature.");
        $poetry->setImgUrl("https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8Ym9va3xlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60");
        $manager->persist($poetry);


        $balto = new Product();
        $balto->setName("Balto");
        $balto->setAvailable(true);
        $balto->setDescription("Balto is a 1995 American live-action/animated adventure film directed by Simon Wells, produced by Amblin Entertainment and distributed by Universal Pictures.[4] The film is loosely based on a true story about the dog of the same name who helped save children infected with diphtheria in the 1925 serum run to Nome.");
        $balto->setPrice(33);
        $balto->setCategory($novel);
        $balto->setImage("https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTB8fGJvb2t8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60");
        $manager->persist(($balto));

        $cid = new Product();
        $cid->setName("Le Cid");
        $cid->setAvailable(true);
        $cid->setDescription("Le Cid is a five-act French tragicomedy written by Pierre Corneille, first performed in December 1636 at the Théâtre du Marais in Paris and published the same year. It is based on Guillén de Castro's play Las Mocedades del Cid.[1] Castro's play in turn is based on the legend of El Cid.");
        $cid->setPrice(22);
        $cid->setCategory($poetry);
        $cid->setImage("https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTB8fGJvb2t8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60");
        $manager->persist(($cid));

        $manager->flush();
    }
}
