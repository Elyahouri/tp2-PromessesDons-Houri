<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Donation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher=$hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUsers($manager);
        $this->loadCampaigns($manager);
        $this->loadDonations($manager);


    }

    public function loadUsers(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail("admin@mail.com")
            ->setPassword($this->hasher->hashPassword($admin,"admin"))
            ->setFirstName("prenom")
            ->setLastName("nom")
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        for ($i = 0; $i<10; $i++){
            $user=new User;
            $user->setEmail($faker->email)
                ->setPassword($this->hasher->hashPassword($user,"user"))
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName);

            $manager->persist($user);
        }



        $manager->flush();

    }
    public function loadCampaigns(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i<5; $i++ ){
            $cmpn = new Campaign();
            $cmpn->setName($faker->word)
                ->setDescription($faker->text(30));
            $manager->persist($cmpn);

        }
        $manager->flush();



    }

    public function loadDonations(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        foreach ($manager->getRepository(Campaign::class)->findAll() as $cmpn) {

            foreach ($manager->getRepository(User::class)->findAll() as $user){

                $don = new Donation();
                $don->setUser($user)
                    ->setAmount($faker->numberBetween(1,10000))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setHonored(false)
                    ->setCampaign($cmpn);
                $manager->persist($don);

            }


        }
        $manager->flush();

    }







    }
