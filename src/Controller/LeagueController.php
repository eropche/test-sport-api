<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Наброски апи для заполнения таблицы с лигами
 * 
 * @Route("/league")
 */
class LeagueController extends AbstractController
{
    /**
     * @Route("/new", name="league_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $name = $request->request->get('name');
        $sportId = $request->request->get('sportId');
        if (!$this->getDoctrine()->getRepository(League::class)->findOneBy(['name' => $name])) {
            $league = new League();
            $league->setName($name);
            if ($sport = $this->getDoctrine()->getRepository(Sport::class)->find($sportId)) $league->setSport($sport);
            $this->getDoctrine()->getRepository(League::class)->save($league);
            return new JsonResponse(['success' => true]);
        }
        
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/{id}/edit", name="league_edit", methods={"POST"})
     */
    public function edit(Request $request, League $league): Response
    {
        $name = $request->request->get('name');
        $sportId = $request->request->get('sportId');
        $league->setName($name);
        if ($sport = $this->getDoctrine()->getRepository(Sport::class)->find($sportId)) $league->setSport($sport);
        $this->getDoctrine()->getRepository(League::class)->update($league);
        
        return new JsonResponse(['success' => false]);
    }
}
