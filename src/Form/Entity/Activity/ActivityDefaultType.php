<?php

namespace App\Form\Entity\Activity;

use App\Entity\Activity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityDefaultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Activity $activity */
        $activity = $options['data'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('type', EntityType::class, [
                'class' => \App\Entity\ActivityType::class,
                'label' => 'Type',
            ])
            ->add('start', DateTimeType::class, [
                'label' => 'Début',
                'widget' => 'single_text',
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'Fin',
                'widget' => 'single_text',
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