<?php

namespace App\Controller\Calendrier;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    /**
     * @Route("/calendrier", name="app_calendrier")
     */
    public function index(CalendarRepository $calendar): Response
    {
        $events = $calendar->findAll();

        $rdv = [];

        foreach ($events as $event) {
            $rdv[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd(),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColo' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
            ];

            $data = json_encode($rdv);
        }
        return $this->render('calendrier/index.html.twig', compact('data'));
    }

    /**
     * @Route("/listeEvents", name="app_listeEvents")
     */
    public function listeEvents(CalendarRepository $calendarse): Response
    {
        $calendars = $calendarse->findAll();
        return $this->render('calendrier/listeEvent.html.twig', [
            'calendars' => $calendars,
        ]);
    }
}
