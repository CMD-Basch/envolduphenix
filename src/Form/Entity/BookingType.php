<?php

namespace App\Form\Entity;

use App\Entity\Booking;
use App\Form\Field\EventOptionsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Booking $booking */
        $booking = $options['data'];

        $builder
            ->add('options', EventOptionsType::class , [
                'event' => $booking->getEvent(),
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults( [
            'data_class' => Booking::class,
        ]);
    }
}