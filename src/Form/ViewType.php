<?php

namespace App\Form;

use App\Entity\View;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var View $view */
        $view = $options['data'];

        $filename = '';
        if ( $view->getImageFile() ) $filename = $view->getImage()->getOriginalName();

        $builder
            ->add('name')
            ->add('title')
            ->add('subtitle')
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => 'view',
                'download_uri' => true,
                'attr' => [
                    'placeholder' => $filename
                ]
            ])
            ->add('content', CKEditorType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => View::class,
        ]);
    }
}
