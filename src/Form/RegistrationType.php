<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\Entity\BookingType;
use App\Form\Entity\UserType;
use App\Service\Event\EventService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    private $sEvent;

    public function __construct( EventService $sEvent )
    {
        $this->sEvent = $sEvent;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $options['user'];
        /** @var Booking $booking */
        $booking = $options['booking'];

        $event = $this->sEvent->getTheEvent();
        $builder->add('user', UserType::class, [
            'data' => $user,
            'label' => false,
        ] );
        if( $event && $event->getOpen() ) {
            $booking->setEvent( $event );
            $builder->add('book', CheckboxType::class, [
                'label' => 'Je m\'enregistre au prochain évènement : '. $event->getName(),
                'required' => false,
                'data' => true,
            ]);
            $builder->add('booking', BookingType::class, [
                'data' => $booking,
                'label' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired( [
            'user',
            'booking',
        ]);

        $resolver->setAllowedTypes('user', User::class);
        $resolver->setAllowedTypes('booking', Booking::class);
    }
}