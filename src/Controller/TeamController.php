<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Наброски апи для заполнения таблицы с командами
 * 
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/new", name="team_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $name = $request->request->get('name');
        $sportId = $request->request->get('sportId');
        $leagueId = $request->request->get('leagueId');
        if (!$this->getDoctrine()->getRepository(Team::class)->findOneBy(['name' => $name])) {
            $team = new League();
            $team->setName($name);
            if ($sport = $this->getDoctrine()->getRepository(Sport::class)->find($sportId)) $team->setSport($sport);
            if ($league = $this->getDoctrine()->getRepository(League::class)->find($sportId)) $team->setLeague($league);
            $this->getDoctrine()->getRepository(Team::class)->save($team);
            return new JsonResponse(['success' => true]);
        }
        
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"POST"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $name = $request->request->get('name');
        $sportId = $request->request->get('sportId');
        $leagueId = $request->request->get('leagueId');
        $team->setName($name);
        if ($sport = $this->getDoctrine()->getRepository(Sport::class)->find($sportId)) $team->setSport($sport);
        if ($league = $this->getDoctrine()->getRepository(League::class)->find($sportId)) $team->setLeague($league);
        $this->getDoctrine()->getRepository(Team::class)->update($team);
        
        return new JsonResponse(['success' => false]);
    }
}
