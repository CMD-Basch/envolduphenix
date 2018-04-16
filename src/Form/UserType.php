<?php
// src/Form/UserType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',   TextType::class,        ['label' => 'Pseudo :'] )
            ->add('firstname',  TextType::class,        ['label' => 'Prénom :'] )
            ->add('lastname',   TextType::class,        ['label' => 'Nom :'] )
            ->add('email',      RepeatedType::class, [
                'type' => EmailType::class,
                'first_options'  => array('label' => 'E-mail :'),
                'second_options' => array('label' => 'Confirmez l\'e-mail :'),
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez le mot de passe'),
            ])
            ->add('sleep', ChoiceType::class, [
                'label' => 'Voulez vous reserver une chambre : ',
                'choices'  => [
                    'Non merci' => 'nope',
                    'Le vendredi soir uniquement ( 5€ )' => 'ven',
                    'Le samedi soir uniquement. ( 5€ )' => 'sam',
                    'Le vendredi et samedi soir. ( 10€ )' => 'ven & sam',
                    ]
            ])
            ->add('save',SubmitType::class,      ['label' => 'S\'enregistrer :'] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults( [
            'data_class' => User::class,
        ]);
    }
}