<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setName("admin");
        $user->setPassword($this->encoder->encodePassword(
            $user,
            'admin'
        ));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail("admin@example.com");
        $user->setCreatedAt(new DateTime("now"));
        $manager->persist($user);
        $manager->flush();
    }

}
