<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Round;
use App\Model\SortableInterface;
use App\Service\Event\EventService;
use App\Service\Form\WeightService;
use App\Service\ItemClassService;
use App\Service\Module\ModuleService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Gedmo\Mapping\Annotation\SortableGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;


class EasyAdminController extends BaseAdminController
{

    protected $sEvent;
    protected $sWeight;
    protected $sClass;
    protected $em;

    public function __construct (
        EventService $sEvent,
        WeightService $sWeight,
        ItemClassService $sClass,
        EntityManagerInterface $em )
    {
        $this->sEvent = $sEvent;
        $this->sWeight = $sWeight;
        $this->sClass = $sClass;
        $this->em = $em;
    }

    public function createActivityTypeEntityFormBuilder ( $entity, $view )
    {
        $formBuilder = parent::createEntityFormBuilder( $entity, $view );

        $formBuilder->add( 'module', ChoiceType::class, [
            'choices' => ModuleService::ModulesList(),
        ] );

        return $formBuilder;
    }

    public function createActivityEntityFormBuilder ( $entity, $view )
    {
        $formBuilder = parent::createEntityFormBuilder( $entity, $view );

        $formBuilder->add( 'round', EntityType::class, [
            'class' => Round::class,
            'required' => false,
            'choice_label' => function ( Round $r = null ) {
                return $r ? $r->getActivityType() . ' - ' . $r->getName() : '';
            },
        ] );

        return $formBuilder;
    }

    protected function listAction ()
    {
        $this->dispatch( EasyAdminEvents::PRE_LIST );

        $fields = $this->entity['list']['fields'];
        $paginator = $this->findAll( $this->entity['class'], $this->request->query->get( 'page', 1 ), $this->entity['list']['max_results'], $this->request->query->get( 'sortField' ), $this->request->query->get( 'sortDirection' ), $this->entity['list']['dql_filter'] );

        $this->dispatch( EasyAdminEvents::POST_LIST, [ 'paginator' => $paginator ] );

        $parameters = [
            'paginator' => $paginator,
            'fields' => $fields,
            'delete_form_template' => $this->createDeleteForm( $this->entity['name'], '__id__' )->createView(),
        ];

        return $this->executeDynamicMethod( 'render<EntityName>Template', [ 'list', $this->entity['templates']['list'], $parameters ] );
    }

    public function weightAction ()
    {
        $referer = $this->request->query->get( 'referer' );
        $act = $this->request->query->get( 'w_act' );
        $easyadmin = $this->request->attributes->get( 'easyadmin' );
        $entity = $easyadmin['item'];

        $this->sWeight->changeWeight( $entity, $act );

        return $this->redirect( urldecode( $referer ) );
    }

    public function exploreAction ()
    {

        $redirect_table = [
            'App\Entity\Menu' => 'View',
        ];

        $class = $redirect_table[ $this->entity['class'] ];

        $easyadmin = $this->request->attributes->get( 'easyadmin' );
        $entity = $easyadmin['item'];


        return $this->redirectToRoute( 'admin', [
            'entity' => $class,
            'action' => 'filter',
            'filterId' => $entity->getId(),
            'filterClass' => $this->sClass->getSnakeClassName( $entity ),
            'menuIndex' => $this->request->query->get( 'menuIndex' ),
            'submenuIndex' => $this->request->query->get( 'submenuIndex' ),
        ] );

    }

    /**
     * The method that is executed when the user performs a 'list' action on an entity.
     *
     * @return Response
     */
    protected function filterAction ()
    {
        $this->dispatch( EasyAdminEvents::PRE_LIST );

        $filterId = $this->request->query->get( 'filterId' );
        $filterClass = $this->request->query->get( 'filterClass' );

        $sortField = $this->entity['list']['sort'][0] ?? 'id';
        $sortDirection = $this->entity['list']['sort'][1] ?? 'ASC';

        $this->entity['list']['dql_filter'] = "entity.$filterClass = $filterId";
        $fields = $this->entity['list']['fields'];

        $paginator = $this->findAll( $this->entity['class'], $this->request->query->get( 'page', 1 ), $this->entity['list']['max_results'], $sortField, $sortDirection, $this->entity['list']['dql_filter'] );

        $this->dispatch( EasyAdminEvents::POST_LIST, [ 'paginator' => $paginator ] );

        $parameters = [
            'paginator' => $paginator,
            'fields' => $fields,
            'delete_form_template' => $this->createDeleteForm( $this->entity['name'], '__id__' )->createView(),
        ];

        return $this->executeDynamicMethod( 'render<EntityName>Template', [ 'list', $this->entity['templates']['list'], $parameters ] );
    }

    protected function createListQueryBuilder ( $entityClass, $sortDirection, $sortField = null, $dqlFilter = null )
    {

        $is_sortable = $this->sClass->isSubclassOf( $this->entity['class'], SortableInterface::class );

        $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata( $this->entity['class'] );

        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select( 'entity' )
            ->from( $this->entity['class'], 'entity' );

        $isSortedByDoctrineAssociation = $this->isDoctrineAssociation( $classMetadata, $sortField );

        if ( $isSortedByDoctrineAssociation ) {
            $sortFieldParts = explode( '.', $sortField );
            $queryBuilder->leftJoin( 'entity.' . $sortFieldParts[0], $sortFieldParts[0] );
        }

        if ( !empty( $dqlFilter ) ) {
            $queryBuilder->andWhere( $dqlFilter );
        }

        if ( $is_sortable ) {
            $orderField = $this->sClass->getAnnotationProperty( $this->entity['class'], SortableGroup::class )->getName();
            $queryBuilder->addOrderBy( sprintf( '%s', 'entity.' . $orderField ), 'ASC' );
            $queryBuilder->addOrderBy( sprintf( '%s', 'entity.position' ), 'ASC' );
        } elseif ( null !== $sortField ) {
            $queryBuilder->addOrderBy( sprintf( '%s%s', $isSortedByDoctrineAssociation ? '' : 'entity.', $sortField ), $sortDirection );
        }


        return $queryBuilder;
    }

    protected function isDoctrineAssociation ( ClassMetadata $classMetadata, $fieldName )
    {
        if ( null === $fieldName ) {
            return false;
        }

        $fieldNameParts = explode( '.', $fieldName );

        return false !== strpos( $fieldName, '.' ) && !array_key_exists( $fieldNameParts[0], $classMetadata->embeddedClasses );
    }

    public function prePersistActivityRPGEntity ( Activity $entity )
    {

        $event = $this->sEvent->getTheEvent();
        $round = $entity->getRound();
        $type = $this->em->getRepository( ActivityType::class )->findOneBy(['slug' => 'jeu-de-roles']);

        $entity
            ->setStart( $round->getStart() )
            ->setEnd( $round->getEnd() )
            ->setEvent( $event )
            ->setType( $type )
        ;
        return parent::prePersistEntity( $entity );
    }

    public function preUpdateActivityRPGEntity ( Activity $entity )
    {

        $round = $entity->getRound();

        $entity
            ->setStart( $round->getStart() )
            ->setEnd( $round->getEnd() )
        ;
        return parent::preUpdateEntity( $entity );
    }

}
