<?php

namespace App\Form;

use App\Controller\BoradgameController;
use App\Controller\RoleplayController;
use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Round;
use App\Service\ActivityUser;
use App\Service\TimeZones;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardgameActivityType extends AbstractType
{

    private $activityUser;
    private $em;
    private $tz;


    public function __construct( ActivityUser $activityUser, EntityManagerInterface $em, TimeZones $tz )
    {
        $this->activityUser = $activityUser;
        $this->em = $em;
        $this->tz = $tz;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $activityType = $this->em->getRepository(ActivityType::class )->findOneBy( ['name' => BoradgameController::ACTIVITY_TYPE_NAME] );
        $builder
            ->add('name',       TextType::class,        ['label' => 'Nom de la partie'])
            ->add('game',       TextType::class,        ['label' => 'Jeu'])
            ->add('style',      TextType::class,        ['label' => 'Style de jeu'])
            ->add('description',TextareaType::class,    ['label' => 'Description'])
            ->add('start',      DateTimeType::class,    ['label' => 'Début'])
            ->add('end',        DateTimeType::class,    ['label' => 'Fin'])
            ->add('slots',      IntegerType::class,     ['label' => 'Places'])
            ->add('slots',      IntegerType::class,     ['label' => 'Places'])
            ->add('round',      EntityType::class,      ['choices' => $this->em->getRepository( Round::class)->findBy(['activityType' => $activityType ]),
                                                                    'class' => Round::class ]  )
            ->add('save',       SubmitType::class,      ['label' => 'Enregister la partie'] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
