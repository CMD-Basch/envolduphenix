<?php

namespace App\Service;


use Doctrine\Common\Annotations\Reader;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class ItemClassService
{
    private $converter;
    private $container;
    private $reader;

    public function __construct( ContainerInterface $container, Reader $reader )
    {
        $this->converter = new CamelCaseToSnakeCaseNameConverter();
        $this->container = $container;
        $this->reader = $reader;
    }

    public function getObject( $item )
    {
        return $this->container->get( $this->getFullClassName( $item ) );
    }

    public function getClass( $item ): \ReflectionClass
    {
        return (new \ReflectionClass( $item ));
    }

    public function isSubclassOf( $item, string $class ): bool
    {
        return $this->getClass( $item )->isSubclassOf( $class );
    }

    public function getFullClassName( $item ): string
    {
        return (new \ReflectionClass( $item ))->getName();
    }

    public function getCamelClassName( $item ): string
    {
        return (new \ReflectionClass( $item ))->getShortName();
    }

    public function getSnakeClassName( $item ): string
    {
        return $this->converter->normalize( $this->getCamelClassName( $item ) );
    }

    public function isClass( $item, string $class )
    {
        return $this->getFullClassName( $item ) === $class;
    }

    public function getAnnotationProperty( $item, string $annotation ){
        $properties = $this->getClass( $item )->getProperties();
        foreach ( $properties as $property ){
            if( $this->reader->getPropertyAnnotation($property , $annotation) )
                return $property;
        }
    }

}