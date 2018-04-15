<?php

namespace App\Form;

use App\Controller\RoleplayController;
use App\Entity\Event;
use App\Entity\Round;
use App\Service\EventUser;
use App\Service\TimeZones;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleplayEventType extends AbstractType
{

    private $eventUser;


    public function __construct( EventUser $eventUser )
    {
        $this->eventUser = $eventUser;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add('name',       TextType::class,        ['label' => 'Nom de la partie'])
            ->add('game',       TextType::class,        ['label' => 'Jeu'])
            ->add('style',      TextType::class,        ['label' => 'Style de jeu'])
            ->add('description',TextareaType::class,    ['label' => 'Description'])
            ->add('slots',      IntegerType::class,     ['label' => 'Places'])
            ->add('round',      EntityType::class,      ['choices' => $this->eventUser->getFreeRounds( RoleplayController::EVENT_TYPE_NAME ),
                                                                    'class' => Round::class ]  )
            ->add('save',       SubmitType::class,      ['label' => 'Enregister la table'] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
