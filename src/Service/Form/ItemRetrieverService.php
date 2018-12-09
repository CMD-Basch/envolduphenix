<?php

namespace App\Service\Form;


use Doctrine\ORM\EntityManagerInterface;

class ItemRetrieverService
{

    private $em;

    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function getItem( string $class, int $id, array $interfaces = [] )
    {
        $item = $this->em->getRepository( $class )->find( $id );

        if ( !$item ) {
            throw new \Error( "ERROR : item from class $class, with id $id not found" );
        }

        foreach ( $interfaces as $interface ) {
            if ( !($item instanceof $interface) ) {
                throw new \Error( "ERROR : class $class does not implements " . $interface );
            }
        }

        return $item;
    }
}