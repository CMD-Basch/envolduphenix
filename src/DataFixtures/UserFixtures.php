<?php

namespace App\DataFixtures;


use App\DataFixtures\Data\UserData;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    private $passwordEncoder;

    public function __construct( UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $datas = UserData::$DATA;

        foreach ( $datas as $data ) {

            $user = new User();

            $user
                ->setUsername( $data['username'] )
                ->setPassword( $this->passwordEncoder->encodePassword( $user, $data['password'] ) )
                ->setEMail( $data['email'] )
                ->setRoles( $data['roles'] )
            ;

            $manager->persist( $user );
            $this->setReference( 'user-' . $data['id'], $user );

        }

        $manager->flush();

    }


    public function getDependencies()
    {
//        return array(
//            GaranteeTypeFixtures::class,
//        );
    }
}
