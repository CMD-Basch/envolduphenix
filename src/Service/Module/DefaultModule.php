<?php


namespace App\Service\Module;


use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Form\Entity\Activity\ActivityDefaultType;
use App\Model\ModuleInterface;
use App\Service\Event\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DefaultModule implements ModuleInterface
{

    const NAME = 'Par défaut';
    const SLUG = 'default';

    protected $sEvent;

    protected $formFactory;
    protected $em;

    protected $activityType;
    protected $activity;
    protected $form;

    public function __construct( EventService $sEvent, FormFactoryInterface $formFactory, EntityManagerInterface $em )
    {
        $this->sEvent = $sEvent;
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    public function init( ActivityType $activityType ) {
        $this->activityType = $activityType;
    }

    public function getSlug(): string {
        return $this::SLUG;
    }

    public function getList() {
        return $this->sEvent->getTheEvent()->getActivities();
    }

    protected function generateNewActivity(): Activity {
        $event = $this->sEvent->getTheEvent();
        $activity = New Activity();
        $activity
            ->setEvent( $event )
            ->setStart( $event->getStart() )
            ->setEnd( $event->getStart() )
        ;

        return $activity;
    }

    public function getActivity(): Activity
    {
        if( !isset( $this->activity ) ){
            $this->activity = $this->generateNewActivity();
        }
        return $this->activity;
    }

    protected function generateNewForm(): FormInterface
    {
        return $this->formFactory->create( ActivityDefaultType::class , $this->getActivity() );
    }

    public function getForm(): FormInterface
    {
        if( !isset( $this->form ) ){
            $this->form = $this->generateNewForm();
        }
        return $this->form;
    }

    public function preSubmit(Request $request) {}

    public function submit()
    {
        $this->em->persist( $this->activity );
        $this->em->flush();
    }
}