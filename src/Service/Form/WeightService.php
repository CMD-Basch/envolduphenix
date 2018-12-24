<?php

namespace App\Service\Form;


use App\Model\SortableInterface;
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

    public function changeWeight( SortableInterface $item, string $act )
    {
        if( !in_array( $act , self::ACTIONS )){
            throw new \Error("ERROR : Invalid act parameter : '$act', valid parameters are : " . implode(', ', self::ACTIONS ));
        }

        $position = $item->getPosition();

        switch ( $act ){
            case 'add' : $position++; break;
            case 'sub' : $position--; break;
        }

        $item->setPosition( $position );

        $this->em->flush();
    }

    /**
     * @param SortableInterface $item
     * @param SortableInterface[] $list
     */
    public static function isFirst( SortableInterface $item, $list ) {
        $smallest = null;
        foreach ( $list as $list_item ){
            if( $smallest === null || $list_item->getPosition() < $smallest ){
                $smallest = $list_item->getPosition();
            }
        }
        return $item->getPosition() == $smallest;
    }

    /**
     * @param SortableInterface $item
     * @param SortableInterface[] $list
     */
    public static function isLast( SortableInterface $item, $list ) {
        $biggest = null;
        foreach ( $list as $list_item ){
            if( $biggest === null || $list_item->getPosition() > $biggest ){
                $biggest = $list_item->getPosition();
            }
        }
        return $item->getPosition() == $biggest;
    }
}