<?php

namespace App\Model;


use App\Entity\Activity;
use App\Entity\ActivityType;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface ModuleInterface
{

    public function init( ActivityType $activityType, array $arguments = [] );

    public function getSlug(): string;

    /**
     * @return Collection|Activity[]
     */
    public function getList();

    public function getActivity(): Activity;
    public function getForm(): FormInterface;
    public function getOptions(): array;

    public function preSubmit( Request $request );
    public function submit();

}