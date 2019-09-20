<?php

namespace App\Service;

use App\Entity\GameBuffer;
use App\Entity\Team;
use App\Entity\Game;
use App\Repository\SportRepository;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use App\Repository\GameRepository;
use App\Repository\GameBufferRepository;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Сервис для работы с сущностями игр
 */
class GameService
{
    private $gameBufferRepository;
    private $sportRepository;
    private $leagueRepository;
    private $teamRepository;
    private $gameRepository;
    private $translator;

    public function __construct(
        GameBufferRepository $gameBufferRepository,
        GameRepository $gameRepository,
        SportRepository $sportRepository,
        LeagueRepository $leagueRepository,
        TeamRepository $teamRepository,
        TranslatorInterface $translator
    ) {
        $this->gameBufferRepository = $gameBufferRepository;
        $this->gameRepository = $gameRepository;
        $this->sportRepository = $sportRepository;
        $this->leagueRepository = $leagueRepository;
        $this->teamRepository = $teamRepository;
        $this->translator = $translator;
    }

    /**
     * Сохранить сырую игру
     * 
     * @param array $games
     */
    public function saveGameBuffer(array $games)
    {
        foreach ($games as $game) {
            $game['matchDate'] = new \DateTime($game['matchDate']);
            $gameBuffer = $this->gameBufferRepository->findOneBy($game);
            if ($gameBuffer) continue;
            $gameBuffer = new GameBuffer($game);
            $this->merge($gameBuffer);
            $this->gameBufferRepository->getEntityManager()->persist($gameBuffer);
        }
        $this->gameBufferRepository->getEntityManager()->flush();
    }
    
    /**
     * Найти и присвоить реальную игру
     * 
     * @param GameBuffer $gameBuffer
     * 
     * @return type
     */
    public function merge(GameBuffer $gameBuffer)
    {
        // на данном этапе подразумеваем, что таблицы спорт, лига и команды заполнены и в них есть исчерпывающая инфа для поиска и создания game
        // насколько я понял задание - прийти в game-buffer может разные названия команд и пр. если сразу все сохранять будет бардак
        
        $sport = $this->sportRepository->findByLikeName($this->translator->trans($gameBuffer->getSport()));
        $league = $this->leagueRepository->findByLikeName($this->translator->trans($gameBuffer->getLeague()));
        if (!$sport || !$league) {
            return; // в этом случае буффер никуда не смержится. мы сможем, повесив уведомление, его вытащить по game=null и понять в чем дело
        }
        $team1 = $this->teamRepository->findByLikeName($this->translator->trans($gameBuffer->getTeam1()), $sport, $league);
        $team2 = $this->teamRepository->findByLikeName($this->translator->trans($gameBuffer->getTeam2()), $sport, $league);
        if (!$team1 || !$team2) {
            return; // в этом случае буффер никуда не смержится. мы сможем, повесив уведомление, его вытащить по game=null и понять в чем дело
        }
        $game = $this->gameRepository->findOneBy(['team1' => $team1, 'team2' => $team2]);
        if (!$game || $game->getMatchDate()->diff($gameBuffer->getMatchDate())->days > 0) {
            $game = $this->createGame($team1, $team2, $gameBuffer->getLanguage(), $gameBuffer->getMatchDate(), $gameBuffer->getSource());
        }
        $gameBuffer->setGame($game);
    }
    
    /**
     * Создать новую реальную игру
     * 
     * @param Team $team1
     * @param Team $team2
     * @param type $language
     * @param \App\Service\DateTime $matchDate
     * @param type $source
     * 
     * @return Game
     */
    private function createGame(Team $team1, Team $team2, $language, DateTime $matchDate, $source)
    {
        $game = new Game();
        $game->setTeam1($team1);
        $game->setTeam2($team2);
        $game->setLanguage($language);
        $game->setMatchDate($matchDate);
        $game->setSource($source);
        $this->gameRepository->getEntityManager()->persist($game);
        
        return $game;
    }
}
