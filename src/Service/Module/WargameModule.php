<?php


namespace App\Service\Module;


use App\Entity\Activity;
use App\Entity\Round;
use App\Form\Entity\Activity\ActivityRoleplayType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class WargameModule extends DefaultModule
{
    const NAME = 'Wargames';
    const SLUG = 'wargame';

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
            'event' => $this->sEvent->getTheEvent()->getId(),
        ] );

        $search_arguments = [
            'activityType' => $this->getActivityType()->getId(),
        ];

        if( $round_slug = $this->arguments[0] ?? null ) {
            $search_arguments['slug'] = $round_slug;
        }
        $round = $this->em->getRepository( Round::class )->findOneBy($search_arguments);

        return [
            'rounds' => $rounds,
            'round' => $round,
            'activityType' => $this->getActivityType(),
        ];
    }

    protected function generateNewActivity(): Activity {
        $event = $this->sEvent->getTheEvent();
        $round = $this->getOptions()['round'];
        $activity = New Activity();
        $activity
            ->setMaster( $this->sUser->getUser() )
            ->setEvent( $event )
            ->setRound( $round )
            ->setType( $this->activityType )
        ;

        return $activity;
    }

    protected function generateNewForm(): FormInterface {
        $a = $this->getActivity();
//        dump($a);
        return $this->formFactory->create( ActivityRoleplayType::class , $a );
    }

    public function preSubmit( Request $request ) {

        $round = $this->getActivity()->getRound();
        $this->getActivity()
            ->setStart( $round->getStart() )
            ->setEnd( $round->getEnd() )
        ;
    }



}
