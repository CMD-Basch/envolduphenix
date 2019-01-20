<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;


class EventController extends EasyAdminController
{


    public function bookingAction() {

        $easyadmin = $this->request->attributes->get('easyadmin');
        /** @var Event $event */
        $event = $easyadmin['item'];

        $rows = [];

        $columns = [
            'Nom',
            'Prénom',
            'Pseudo',
            'Email',
        ];

        $options = $event->getOptions();

        foreach( $options as $option ){
            array_push( $columns, '"'.$option['key'].'"' );
        }


        array_push( $rows, implode(',', $columns ) );

        $bookings = $event->getBookings();
        foreach ( $bookings as $booking ){
            $user = $booking->getUser();
            $row = [
                $user->getLastName(),
                $user->getFirstName(),
                $user->getUsername(),
                $user->getEmail(),
            ];


            foreach( $booking->getOptions() as $key => $option ){
                $index =  substr($key, -1);

                if( ( $options[$index]['value'] ?? false ) === ChoiceType::class){
                    $choices = explode(';', $options[$index]['options'] );
                    array_push($row,'"'.$choices[$option].'"' ?? false );
                }
                else{
                    array_push($row, '"'.$option.'"');
                }

            }
            array_push( $rows,implode(',', $row));
        }

        $file = implode("\n",$rows);

        $response = new Response($file);
        $response->headers->replace([
            'Content-type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="inscriptions.csv"'
        ]);

        return $response;
    }

}