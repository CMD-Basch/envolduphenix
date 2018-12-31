<?php

namespace App\Form\Entity\Activity;

use App\Entity\Activity;
use App\Entity\Round;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityRoleplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Activity $activity */
        $activity = $options['data'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('round', EntityType::class, [
                'class' => Round::class,
                'choices' => $activity->getEvent()->getRoundsByActivityType( $activity->getType() ),
                'mapped' => false,
            ])
            ->add('game', TextType::class, [
                'label' => 'Jeu',
            ])
            ->add('style', TextType::class, [
                'label' => 'Style',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('slots', IntegerType::class, [
                'label' => 'Places',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults( [
            'data_class' => Activity::class,
        ]);
    }
}