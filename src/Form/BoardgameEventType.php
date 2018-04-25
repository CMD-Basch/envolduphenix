<?php

namespace App\Form;

use App\Controller\BoradgameController;
use App\Controller\RoleplayController;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use App\Service\EventUser;
use App\Service\TimeZones;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardgameEventType extends AbstractType
{

    private $eventUser;
    private $em;


    public function __construct( EventUser $eventUser, EntityManagerInterface $em )
    {
        $this->eventUser = $eventUser;
        $this->em = $em;
    }

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $eventType = $this->em->getRepository(EventType::class )->findOneBy( ['name' => BoradgameController::EVENT_TYPE_NAME] );
        $builder
            ->add('name',       TextType::class,        ['label' => 'Nom de la partie'])
            ->add('game',       TextType::class,        ['label' => 'Jeu'])
            ->add('style',      TextType::class,        ['label' => 'Style de jeu'])
            ->add('description',TextareaType::class,    ['label' => 'Description'])
            ->add('slots',      IntegerType::class,     ['label' => 'Places'])
            ->add('round',      EntityType::class,      ['choices' => $this->em->getRepository( Round::class)->findBy(['eventType' => $eventType ]),
                                                                    'class' => Round::class ]  )
            ->add('save',       SubmitType::class,      ['label' => 'Enregister la partie'] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
