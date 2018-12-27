<?php

namespace App\Form\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyValueOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', TextType::class, [
                'label' => 'Libéllé',
            ] )
            ->add('value', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Texte' => TextType::class,
                    'Choix multiples' => ChoiceType::class,
                    'Nombre' => IntegerType::class,
                ]
            ] )
            ->add('options', TextType::class, [
                'label' => 'Options',
            ] )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }

}
