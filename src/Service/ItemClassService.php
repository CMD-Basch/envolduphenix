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
        return $this->container->get( $this->getFullClassName( $item ) );
    }

    public function getClass( $item ): \ReflectionClass
    {
        return (new \ReflectionClass( $item ));
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

}