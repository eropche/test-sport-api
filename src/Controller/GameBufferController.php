<?php

namespace App\Controller;

use App\Service\GameService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Приложение по REST API получает следующие данные о спортивных событиях 
 * Будем считать что приложению отправляют эти данные.
 * Но всегда можно подключить например Guzzle и получать данные с внешних апи
 * 
 * @Route("/game-buffer")
 */
class GameBufferController extends AbstractController
{
    private $gameService;
    
    public function __construct(GameService $gameService) {
        $this->gameService = $gameService;
    }

    /**
     * @Route("/", name="game-buffer", methods={"POST"})
     */
    public function gameBuffer(Request $request): Response
    {
        $games = $request->request->get('games');
        $this->gameService->saveGameBuffer($games);
        
        return new JsonResponse(['success' => true]);
    }
}
