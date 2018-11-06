<?php

namespace App\DataFixtures;


use App\DataFixtures\Data\MenuData;
use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $datas = MenuData::$DATA;

        foreach ( $datas as $data ) {

            $menu = new Menu();

            $menu
                ->setName( $data['name'] )
                ->setWeight( $data['weight'] )
                ->setColor( $data['active'] )
                ->setPic( $data['pic'] )
                ->setActive( $data['active'] )
            ;

            $manager->persist( $menu );
            $this->setReference( 'menu-' . $data['id'], $menu );

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
