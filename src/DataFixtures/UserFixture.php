<?php

namespace App\DataFixtures;

use App\Entity\Member;
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
    $member = new Member();
    $member->setUsername('arts');

    $member->setPassword(
        $this->encoder->encodePassword($member, 'qwerty')
    );

    $member->setEmail('arts@gmail.com');

    $manager->persist($member);

    $manager->flush();
    }
}
