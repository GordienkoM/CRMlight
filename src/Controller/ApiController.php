<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Event $event, Request $request, ManagerRegistry $doctrine)
    {
        // retrieve the data
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ){
            // the data is complete
             // initialize a code
            $code = 200;

            // check if the id exists
            if(!$event){

                $event = new Event;

                // change a code
                $code = 201;
            }

            // hydrate the object with the data
            $event->setTitle($donnees->title);
            $event->setDescription($donnees->description);
            $event->setStart(new DateTime($donnees->start));
            if($donnees->allDay){
                $event->setEnd(new DateTime($donnees->start));
            }else{
                $event->setEnd(new DateTime($donnees->end));
            }
            $event->setAllDay($donnees->allDay);
            $event->setBackgroundColor($donnees->backgroundColor);
            $event->setBorderColor($donnees->borderColor);
            $event->setTextColor($donnees->textColor);

            // connected in user
            $user = $this->getUser();
            $event->setOwner($user);


            $entityManager = $doctrine->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // return the code
            return new Response('Ok', $code);
        }else{
            // Data is incomplete
            return new Response('Données incomplètes', 404);
        }

    }
}
