<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Service\ActivityButton;
use App\Service\ActivityUser;

use App\Service\Event\EventService;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{

    private $em;
    private $user;
    private $activityUser;
    private $activityButton;


    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, ActivityUser $activityUser, ActivityButton $activityButton)
    {
        $this->em = $em;
        $this->activityUser = $activityUser;
        $this->activityButton = $activityButton;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @Route("/profil/editer", name="profile.edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder ) {

        $form = $this->createForm(UserEditType::class, $this->getUser() );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            /** @var User $user */
            $user = $this->getUser();

            $password = $form->get('confirm_password')->getData();

            if( $passwordEncoder->isPasswordValid( $user, $password ) ){
                if ( $password = $form->get('change_password')->getData() ) {
                    $user->setPassword( $passwordEncoder->encodePassword( $user, $password ) );
                }
                $this->getDoctrine()->getManager()->flush();
            }

        }

        return $this->render('envol/pages/register/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/profil/emploi-du-temps", name="schedule")
     */
    public function schedule( EventService $sEvent ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $user */
        $user = $this->getUser();

        $title = [
            'color' => 'bd-bleu',
            'pic' => 'images/title/blk.png',
            'name' => 'Mon profil',
        ];

        return $this->render('envol/pages/schedule.html.twig', [
                'title' => $title,
                'user' => $user,
                'event' => $sEvent->getTheEvent(),
            ]);
    }

}