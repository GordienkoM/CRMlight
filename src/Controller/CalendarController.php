<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(EventRepository $event): Response
    {
        // connected in user
        $user = $this->getUser();
        $events = $event->findBy(
            ['owner' => $user ],
        );

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay(),
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('calendar/index.html.twig', compact('data'));
    }
}
