<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $encoder;
    protected $array;

    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }
    // $product = new Product();
    // $manager->persist($product);

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \faker\Factory($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $admin = new User;
        $telephone = 0760050406;
        $encode = $this->encoder->encodePassword($admin, "password");

        $admin->setEmail("admin@gmail.com")

            ->setPassword($encode)
            ->setRolePermission("ADMIN")
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName($faker->firstName())
            ->setName($faker->name())
            ->setJob($faker->jobTitle())
            ->setTelephone($telephone)
            ->setIsActive($faker->boolean());



        $manager->persist($admin);


        for ($u = 0; $u < 50; $u++) {
            $user = new User();
            $telephone = 0760050406;
            $encode = $this->encoder->encodePassword($user, "password");

            $user->setEmail("user$u@gmail.com")
                ->setFirstName($faker->firstName())
                ->setName($faker->name())
                ->setPassword($encode)
                ->setTelephone($telephone)
                ->setIsActive($faker->boolean())
                ->setRolePermission("USER")
                ->setJob($faker->jobTitle());

            $manager->persist($user);
        }
        $manager->flush();
    }
}
