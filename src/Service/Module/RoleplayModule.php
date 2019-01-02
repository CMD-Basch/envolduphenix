<?php


namespace App\Service\Module;


use App\Entity\Activity;
use App\Entity\Round;
use App\Form\Entity\Activity\ActivityRoleplayType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class RoleplayModule extends DefaultModule
{
    const NAME = 'Jeu de rôle';
    const SLUG = 'roleplay';

    public function getList() {
        $roundSlug = $this->arguments[0] ?? null;

        $criteria = [
          'activityType' => $this->getActivityType()->getId(),
          'event' => $this->getActivity()->getEvent()->getId(),
        ];

        if( $roundSlug ){
            $criteria['slug'] = $roundSlug;
        }

        $round = $this->em->getRepository( Round::class )->findOneBy( $criteria );

        return $this->sEvent->getTheEvent()->getActivities()->filter( function ( Activity $a ) use ( $round ) {
            return $a->getType() == $this->activityType
                && $a->getRound() == $round;
        });
    }

    public function getOptions(): array
    {
        $rounds = $this->em->getRepository( Round::class )->findBy( [
            'activityType' => $this->getActivityType()->getId(),
            'event' => $this->getActivity()->getEvent()->getId(),
        ] );

        return [
            'rounds' => $rounds,
        ];
    }

    protected function generateNewActivity(): Activity {
        $event = $this->sEvent->getTheEvent();
        $activity = New Activity();
        $activity
            ->setEvent( $event )
            /*->setStart( $event->getStart() )
            ->setEnd( $event->getStart() )*/
            ->setType( $this->activityType )
        ;

        return $activity;
    }

    protected function generateNewForm(): FormInterface {
        return $this->formFactory->create( ActivityRoleplayType::class , $this->getActivity() );
    }

    public function preSubmit( Request $request ) {
        /** @var Round $round */
        $round = $this->getForm()->get('round')->getData();
        $this->getActivity()
            ->setStart( $round->getStart() )
            ->setEnd( $round->getEnd() )
        ;
    }



}