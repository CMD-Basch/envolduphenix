<?php

namespace App\Controller\Admin;

use App\Service\Form\WeightService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class EasyAdminController extends BaseAdminController
{

    private $sWeight;

    public function __construct( WeightService $sWeight )
    {
       $this->sWeight = $sWeight;
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

        dd($this->request->query);
    }
}