<?php


namespace App\Service\Module;


use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Event;
use App\Form\Entity\Activity\ActivityDefaultType;
use App\Model\ModuleInterface;
use App\Service\Date\DateFrService;
use App\Service\Event\EventService;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DefaultModule implements ModuleInterface
{

    const NAME = 'Par défaut';
    const SLUG = 'default';

    protected $sEvent;
    protected $sUser;
    private $sDateFr;

    protected $formFactory;
    protected $em;

    protected $activityType;
    protected $activity;
    protected $form;
    protected $arguments;

    public function __construct(
        UserService $sUser,
        EventService $sEvent,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        DateFrService $sDateFr)
    {
        $this->sEvent = $sEvent;
        $this->sUser = $sUser;
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->sDateFr = $sDateFr;
    }

    public function init( ActivityType $activityType, array $arguments = [] ) {
        $this->activityType = $activityType;
        $this->arguments = $arguments;
    }

    public function getSlug(): string {
        return $this::SLUG;
    }

    private function getDayFromSlug(Event $event, string $slug): ?\DateTime{
        $day = null;
        $week = $this->sEvent->getDays($event);
        foreach ( $week as $checkDay ) if( $slug == $this->sDateFr->dayAndNbSlug( $checkDay )){
            $day = $checkDay;
            break;
        }
        return $day;
    }

    public function getList() {

        $event = $this->sEvent->getTheEvent();
        $week = $this->sEvent->getDays( $event );
        $daySlug = $this->arguments[0] ?? '';

        $day = $this->getDayFromSlug( $event, $daySlug );

        if(!$day) {
            $day = current($week);
        }

        return $event->getActivities()->filter( function( Activity $a ) use ( $day ) {
            return $a->getStart()->format('z') == $day->format('z');
        });
    }

    public function getActivityType(): ActivityType {
        return $this->activityType;
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

    public function getOptions(): array {
        $event = $this->sEvent->getTheEvent();
        $week = $this->sEvent->getDays( $event );
        $daySlug = $this->arguments[0] ?? '';

        $day = $this->getDayFromSlug( $event, $daySlug );

        return [
            'week' => $week,
            'day' => $day,
        ];
    }

    public function preSubmit(Request $request) {}

    public function submit()
    {
        $this->em->persist( $this->activity );
        $this->em->flush();
    }
}