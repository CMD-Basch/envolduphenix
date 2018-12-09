<?php

namespace App\Service\File;


use App\Entity\View;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class Namer implements NamerInterface
{

    public function name( $object, PropertyMapping $mapping ): string
    {
        /** @var View $object */
        $ext = $object->getImageFile()->guessExtension();
        return $object->getId().'.'.$ext;
    }
}