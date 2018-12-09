<?php

namespace App\Service;


use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class ItemClassService
{
    private $converter;
    private $container;

    public function __construct( ContainerInterface $container )
    {
        $this->converter = new CamelCaseToSnakeCaseNameConverter();
        $this->container = $container;
    }

    public function getObject( $item )
    {
        return $this->container->get( $this->getClassName( $item ) );
    }

    public function getClass( $item ): \ReflectionClass
    {
        return (new \ReflectionClass( $item ));
    }

    public function getClassName( $item ): string
    {
        return (new \ReflectionClass( $item ))->getName();
    }

    public function getShortClass( $item ): string
    {
        return (new \ReflectionClass( $item ))->getShortName();
    }

    public function getSnakeName( $item ): string
    {
        return $this->converter->normalize( $this->getShortClass( $item ) );
    }

    public function isClass( $item, string $class )
    {
        return $this->getClassName( $item ) === $class;
    }

}