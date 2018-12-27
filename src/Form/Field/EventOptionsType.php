<?php

namespace App\Form\Field;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Event $event */
        $event  = $options['event'];

        foreach( $event->getOptions() as $key => $option ){
            $field_options = [
                'label' => $option['key'],
                'required' => false,
            ];

            if( $option['value'] == ChoiceType::class ){
                $field_options['choices'] = array_flip( explode(';', $option['options']) );
            }

            $builder->add('option-'.$key, $option['value'], $field_options );
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'event' => null
        ]);
    }

}
