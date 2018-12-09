<?php

namespace App\Form;

use App\Controller\RoleplayController;
use App\Entity\Activity;
use App\Entity\Round;
use App\Service\ActivityUser;
use App\Service\TimeZones;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleplayActivityType extends AbstractType
{

    private $activityUser;


    public function __construct( ActivityUser $activityUser )
    {
        $this->activityUser = $activityUser;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add('name',       TextType::class,        ['label' => 'Nom de la partie'])
            ->add('game',       TextType::class,        ['label' => 'Jeu'])
            ->add('style',      TextType::class,        ['label' => 'Style de jeu'])
            ->add('description',TextareaType::class,    ['label' => 'Description'])
            ->add('slots',      IntegerType::class,     ['label' => 'Places'])
            ->add('round',      EntityType::class,      ['choices' => $this->activityUser->getFreeRounds( RoleplayController::ACTIVITY_TYPE_NAME ),
                                                                    'class' => Round::class ]  )
            ->add('save',       SubmitType::class,      ['label' => 'Enregister la table'] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
