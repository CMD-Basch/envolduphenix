<?php

namespace App\Controller\Admin;

use App\Service\Form\WeightService;
use App\Service\ItemClassService;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

class EasyAdminController extends BaseAdminController
{

    protected $sWeight;
    protected $sClass;
    protected $em;

    public function __construct( WeightService $sWeight, ItemClassService $sClass, EntityManagerInterface $em )
    {
       $this->sWeight = $sWeight;
       $this->sClass = $sClass;
       $this->em = $em;
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
            'filterClass' => $this->sClass->getSnakeClassName( $entity ),
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

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        dump($this->entity);
        $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata($this->entity['class']);

        $queryBuilder= $this->em->createQueryBuilder();
        $queryBuilder
            ->select('entity')
            ->from($this->entity['class'], 'entity')
        ;

        $isSortedByDoctrineAssociation = $this->isDoctrineAssociation($classMetadata, $sortField);

        if ($isSortedByDoctrineAssociation) {
            $sortFieldParts = explode('.', $sortField);
            $queryBuilder->leftJoin('entity.'.$sortFieldParts[0], $sortFieldParts[0]);
        }

        if (!empty($dqlFilter)) {
            $queryBuilder->andWhere($dqlFilter);
        }

        if (null !== $sortField) {
            $queryBuilder->addOrderBy(sprintf('%s%s', $isSortedByDoctrineAssociation ? '' : 'entity.', $sortField), $sortDirection);
        }

        return $queryBuilder;
    }

    protected function isDoctrineAssociation(ClassMetadata $classMetadata, $fieldName)
    {
        if (null === $fieldName) {
            return false;
        }

        $fieldNameParts = explode('.', $fieldName);

        return false !== strpos($fieldName, '.') && !array_key_exists($fieldNameParts[0], $classMetadata->embeddedClasses);
    }

}