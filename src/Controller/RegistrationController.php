<?php
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/enregistrement", name="subscribe")
     */
    public function registerAction( Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer ) {


        $user = new User();
        $form = $this->createForm(UserType::class, $user );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            $user
                ->setPassword( $passwordEncoder->encodePassword( $user, $user->getPassword() ) )
                ->setHash( $passwordEncoder->encodePassword( $user, $user->getEmail() ))
                ->setValid(false )
                ->setActive( false )
                ->setCreated( new \DateTime('now') )
                ->setUpdated( new \DateTime('now') )
                ->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);


            $message = (new \Swift_Message('L\'envol du Phénix : Validation de votre inscription' ))
                ->setFrom('lephenixcadurcien@live.fr' )
                ->setTo( $user->getEmail() )
                ->setBody(
                    $this->renderView('email/registration.html.twig', [
                        'name' => $user->getUsername(),
                        'hash' => $user->getHash(),
                        ]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $em->flush();

            return $this->redirectToRoute('subscribe.done');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/enregistrement/fini", name="subscribe.done")
     */
    public function registerDoneAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        return $this->render('security/register-done.html.twig');
    }

    /**
     * @Route("/validation/{hash}", name="validate", requirements={"hash"=".+"})
     */
    public function validateAction( $hash ) {

        /** @var UserRepository $repo */
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['hash' => $hash]);

        if($user){

            if($user->getValid()){
                return $this->render('envol/message.html.twig', [
                    'message' => 'Votre compte est déjà valide.',
                    'title' => 'Validation du compte',
                    'subtitle' => 'Erreur'
                ]);
            }
            $em = $this->getDoctrine()->getManager();
            $user->setValid( true );
            $em->persist($user);
            $em->flush();

            return $this->render('envol/message.html.twig', [
                'message' => 'Votre compte à bien été validé.<br> Vous pouvez à présent vous connecter.',
                'title' => 'Validation du compte',
                'subtitle' => 'Compte validé'
            ]);

        }
        else {
            return $this->render('envol/message.html.twig', [
                'message' => 'Il y a eu une erreur dans le processus de validation.', // TODO : Lien pour aide.
                'title' => 'Validation du compte',
                'subtitle' => 'Erreur'
            ]);
        }

    }


}