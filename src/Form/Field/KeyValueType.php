<?php

namespace App\Form\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', $options['key_type'], $options['key_options'] )
            ->add('value', $options['value_type'], $options['value_options'] )
        ;

        $builder->addModelTransformer( new CallbackTransformer(
            function( $d ) {
                if( !is_array($d) ) return $d;
                $in = [
                    'key' => key($d),
                    'value' => current($d)
                ];
                return $in;
            },
            function ( $d ) {
                if( !is_array($d) ) return $d;
                $out = [
                    $d['key'] ?? '' => $d['value'] ?? ''
                ];

                return $out;
            })
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'key_type' => TextType::class,
            'key_options' => [],
            'value_type' => TextType::class,
            'value_options' => [],
        ]);
    }

}
