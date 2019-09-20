<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/random-game", name="random-game", methods={"GET"})
     */
    public function getRandomGame(Request $request): Response
    {
        $querySource = $request->query->get('source', null);
        $queryMatchDateFrom = $request->query->get('matchDateFrom', null);
        $queryMatchDateTo = $request->query->get('matchDateTo', null);
        $count = $this->getDoctrine()->getRepository(Game::class)->getCount($querySource, $queryMatchDateFrom, $queryMatchDateTo);
        $randomGame = $this->getDoctrine()->getRepository(Game::class)->find(rand(1, $count));
        
        return new JsonResponse($randomGame);
    }
}
