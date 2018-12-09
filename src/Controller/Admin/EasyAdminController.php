<?php

namespace App\Controller\Admin;

use App\Service\Form\WeightService;
use App\Service\ItemClassService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Response;

class EasyAdminController extends BaseAdminController
{

    private $sWeight;
    private $sClass;

    public function __construct( WeightService $sWeight, ItemClassService $sClass )
    {
       $this->sWeight = $sWeight;
       $this->sClass = $sClass;
    }

    public function weightAction()
    {
        $referer = $this->request->query->get('referer');
        $act = $this->request->query->get('w_act');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        $this->sWeight->changeWeight( $entity, $act );

        return $this->redirect( urldecode($referer) );
    }

    public function exploreAction() {

        $redirect_table = [
            'App\Entity\Menu' => 'View'
        ];

        $class = $redirect_table[ $this->entity['class'] ];

        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];


        return $this->redirectToRoute('admin', [
            'entity' => $class,
            'action' => 'filter',
            'filterId' => $entity->getId(),
            'filterClass' => $this->sClass->getSnakeName( $entity ),
            'menuIndex' => $this->request->query->get('menuIndex'),
            'submenuIndex' => $this->request->query->get('submenuIndex'),
            ]);

    }

    /**
     * The method that is executed when the user performs a 'list' action on an entity.
     *
     * @return Response
     */
    protected function filterAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_LIST);

        $filterId = $this->request->query->get('filterId');
        $filterClass = $this->request->query->get('filterClass');

        $sortField = $this->entity['list']['sort'][0] ?? 'id';
        $sortDirection = $this->entity['list']['sort'][1] ?? 'ASC';

        $this->entity['list']['dql_filter'] = "entity.$filterClass = $filterId";
        $fields = $this->entity['list']['fields'];

        $paginator = $this->findAll($this->entity['class'], $this->request->query->get('page', 1), $this->entity['list']['max_results'], $sortField, $sortDirection, $this->entity['list']['dql_filter']);

        $this->dispatch(EasyAdminEvents::POST_LIST, array('paginator' => $paginator));

        $parameters = array(
            'paginator' => $paginator,
            'fields' => $fields,
            'delete_form_template' => $this->createDeleteForm($this->entity['name'], '__id__')->createView(),
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('list', $this->entity['templates']['list'], $parameters));
    }

}