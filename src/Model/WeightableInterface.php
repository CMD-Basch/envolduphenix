<?php

namespace App\Model;


interface WeightableInterface
{

    public function weightFilters(): array;
    public function getWeight(): ?int;
    public function setWeight( int $weight );
    public function getParentClass();
    public function getParent();
    public function setParent( $parent );

    public function isFirst(): bool;

}