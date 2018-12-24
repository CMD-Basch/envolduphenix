<?php

namespace App\Model;


interface SortableInterface
{

    public function setPosition( $position );
    public function getPosition();

    public function isFirst(): bool;
    public function isLast(): bool;

}