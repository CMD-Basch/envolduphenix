<?php
namespace App\Controller;

use App\Entity\Booking;
use App\Form\Entity\BookingType;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @route("/book", name="book")
     */
    public function bookAction( Request $request, EventService $sEvent )
    {
        /** @var User $user */
        $user = $this->getUser();
        $event = $sEvent->getTheEvent();

        if( !$event || !$event->getOpen() ) return $this->redirectToRoute( 'home' );

        foreach( $user->getBookings() as $booking ){
            if( $booking->getEvent() === $event ){
                return $this->redirectToRoute( 'home' );
            }
        }
        $booking = new Booking();
        $booking->setUser( $user )
                ->setEvent( $event )
                ->setBooked( true );

        $form = $this->createForm(BookingType::class, $booking );
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            $this->getDoctrine()->getManager()->persist( $booking );
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute( 'home' );
        }



        return $this->render('envol/pages/register/book.html.twig', array(
            'title' => [
                'name' => 'Réservation',
            ],
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/enregistrement", name="subscribe")
     */
    public function registerAction( Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer ) {


        $user = new User();
        $booking = new Booking();
        $form = $this->createForm(RegistrationType::class, null, [
            'user' => $user,
            'booking' => $booking,
        ] );
//        $form = $this->createForm(UserType::class, $user );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            $user
                ->setPassword( $passwordEncoder->encodePassword( $user, $user->getPassword() ) )
                ->setRoles(['ROLE_USER']);

            $booking
                ->setUser( $user )
                ->setBooked( $form->getData()['book'] || false );


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($booking);


//            $message = (new \Swift_Message('L\'envol du Phénix : Validation de votre inscription' ))
//                ->setFrom('lephenixcadurcien@live.fr' )
//                ->setTo( $user->getEmail() )
//                ->setBody(
//                    $this->renderView('email/registration.html.twig', [
//                        'name' => $user->getUsername(),
//                        'hash' => 'hash',
//                        ]
//                    ),
//                    'text/html'
//                );
//
//            $mailer->send($message);

            $em->flush();

            return $this->redirectToRoute('subscribe.done');
        }

        return $this->render('envol/pages/register/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/enregistrement/fini", name="subscribe.done")
     */
    public function registerDoneAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        return $this->render('envol/pages/register/register-done.html.twig');
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