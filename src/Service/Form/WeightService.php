<?php

namespace App\Service\Form;


use App\Model\WeightableInterface;
use App\Service\ItemClassService;
use Doctrine\ORM\EntityManagerInterface;

class WeightService
{
    private $em;
    private $sClass;

    const ACTIONS = ['add','sub'];

    public function __construct( EntityManagerInterface $em, ItemClassService $sClass )
    {
        $this->em = $em;
        $this->sClass = $sClass;
    }

    public function changeWeight( WeightableInterface $item, string $act )
    {
        if( !in_array( $act , self::ACTIONS )){
            throw new \Error("ERROR : Invalid act parameter : '$act', valid parameters are : " . implode(', ', self::ACTIONS ));
        }
        $filters = [];
        foreach( $item->weightFilters() as $wFilter ) {
            $function = 'get'.ucfirst( $wFilter );
            if( !is_callable( [ $item, $function ] )) {
                throw new \Error("ERROR : Cannot call " . $this->sClass->getCamelClassName( $item ) . "::$function()" );
            }

            $filters[ $wFilter ] = $item->$function();
        }

        /** @var WeightableInterface[] $list */
        $list = $this->em->getRepository( $this->sClass->getFullClassName( $item) )->findBy( $filters, ['weight' => 'ASC'] );

        foreach( $list as $key => $object ){
            $object->setWeight( $key );
        }
        $key = array_search( $item, $list );

        switch ( $act ){
            case 'add' : $key++; break;
            case 'sub' : $key--; break;
        }

        $switch = $list[$key] ?? null;
        if( !$switch ) {
            throw new \Error("ERROR : Key '$key' out of bounds. Valid values are between 0 and ". ( count($list) -1 ).".\n Maybe you try to move up the first item or move down the last.");
        }

        $switch->setWeight( $item->getWeight() );
        $item->setWeight( $key );

        $this->em->flush();
    }
}