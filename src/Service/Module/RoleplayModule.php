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
        return $this->sEvent->getTheEvent()->getActivities()->filter( function (Activity $a ){
            return $a->getType() == $this->activityType;
        });
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