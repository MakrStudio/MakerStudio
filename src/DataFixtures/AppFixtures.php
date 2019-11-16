<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $user,
                        '1234'
                    )
                )
                ->setUsername("example${i}")
            ;

            $manager->persist($user);
        }

        $admin = new User();
        $admin
            ->setUsername("admin")
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $admin,
                    '1234'
                )
            )
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($admin);

        $manager->flush();
    }
}
