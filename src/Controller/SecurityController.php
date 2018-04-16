<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

    /*
     * @Route("/load", name="load")
     */
   /* public function loadUserBase() {

        $users = $this->getDoctrine()->getRepository( User::class )->findAll();
        foreach ( $users as $user){
            $this->getDoctrine()->getManager()->remove($user);
        }

        $this->getDoctrine()->getManager()->flush();


        $conn = $this->getDoctrine()->getConnection();
        $sql = 'SELECT * FROM conv_user';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $raw_users = $stmt->fetchAll();

        dump($raw_users);

        foreach($raw_users as $raw_user) {
            $role = ['ROLE_USER'];
            if( $raw_user['rights'] == '1' ){
                $role = ['ROLE_ADMIN'];
            }

            $user =  new User();
            $user
                ->setUsername( $raw_user['login'] )
                ->setFirstname( $raw_user['prenom'] )
                ->setLastName( $raw_user['nom'] )
                ->setEMail( $raw_user['mail'] )
                ->setPassword( $raw_user['password'] )
                ->setHash( $raw_user['hash'] )
                ->setValid( $raw_user['valid'] )
                ->setActive( $raw_user['valid'] )
                ->setCreated( new \DateTimeImmutable() )
                ->setUpdated( new \DateTimeImmutable() )
                ->setRoles( $role )
            ;
            $this->getDoctrine()->getManager()->persist($user);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->render('envol/pages/text.html.twig', array(
            'page' => '',
        ));
    }*/

}