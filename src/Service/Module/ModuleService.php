<?php

namespace App\Service\Module;


use App\Entity\ActivityType;
use App\Model\ModuleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ModuleService
{
    const MODULES = [
        DefaultModule::class,
        RoleplayModule::class,
        WargameModule::class,
        AllModule::class,
    ];

    private $container;

    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

    public function load( ActivityType $activityType, array $arguments = [] ): ?ModuleInterface {
        /** @var ModuleInterface $module */
        $module =  $this->container->get( $activityType->getModule() );
        $module->init( $activityType, $arguments );
        return $module;
    }

    public static function ModulesList(): array {
        $array = [];
        foreach( self::MODULES as $MODULE ){
            $array[$MODULE::NAME] = $MODULE;
        }
        return $array;
    }

}