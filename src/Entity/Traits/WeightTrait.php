<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait WeightTrait
{
    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    public function getWeight(): ?int
    {
        return $this->weight;
    }


    public function setWeight( int $weight ): self
    {
        $this->weight = $weight;

        return $this;
    }

}