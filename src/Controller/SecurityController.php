<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/profil/editer", name="profile.edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder ) {

        $form = $this->createForm(UserEditType::class, $this->getUser() );


        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            dump($form->get('confirm_password')->getData());

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

        return $this->render('security/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}