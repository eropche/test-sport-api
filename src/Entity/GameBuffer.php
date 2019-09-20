<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferRepository")
 */
class GameBuffer extends AbstractGame implements JsonSerializable
{
    /**
     * @ORM\Column(name="sport", type="string")
     */
    protected $sport;
    
    /**
     * @ORM\Column(name="league", type="string")
     */
    protected $league;
    
    /**
     * По хорошему можно сделать team_home и team_guest. Но я не до конца уверен что всегда играют так
     * 
     * @ORM\Column(name="team1", type="string")
     */
    protected $team1;
    
    /**
     * @ORM\Column(name="team2", type="string")
     */
    protected $team2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gamesBuffer")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=true)
     */
    protected $game;
    
    public function __construct(array $gameBuffer)
    {
        $this->sport = $gameBuffer['sport'];
        $this->language = $gameBuffer['language'];
        $this->matchDate = $gameBuffer['matchDate'];
        $this->source = $gameBuffer['source'];
        $this->league = $gameBuffer['league'];
        $this->team1 = $gameBuffer['team1'];
        $this->team2 = $gameBuffer['team2'];
        $this->createdAt = new \DateTime();
    }
    
    /**
     * Get sport
     * @return string
     */
    public function getSport(): ?string
    {
        return $this->sport;
    }
    
    /**
     * Set sport
     *
     * @param string $sport
     *
     * @return GameBuffer
     */
    public function setSport(string $sport)
    {
        $this->sport = $sport;

        return $this;
    }
    
    /**
     * Get league
     * @return string
     */
    public function getLeague(): ?string
    {
        return $this->league;
    }
    
    /**
     * Set $league
     *
     * @param string $league
     *
     * @return GameBuffer
     */
    public function setLeague(string $league)
    {
        $this->league = $league;

        return $this;
    }
    
    /**
     * Get team1
     * @return string
     */
    public function getTeam1(): ?string
    {
        return $this->team1;
    }
    
    /**
     * Set team1
     *
     * @param string $team1
     *
     * @return GameBuffer
     */
    public function setTeam1(string $team1)
    {
        $this->team1 = $team1;

        return $this;
    }
    
    /**
     * Get team2
     * @return string
     */
    public function getTeam2(): ?string
    {
        return $this->team2;
    }
    
    /**
     * Set team2
     *
     * @param string $team2
     *
     * @return GameBuffer
     */
    public function setTeam2(string $team2)
    {
        $this->team2 = $team2;

        return $this;
    }
    
    /**
     * Get game
     * @return Game
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }
    
    /**
     * Set game
     *
     * @param Game $game
     *
     * @return GameBuffer
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }
    
    public function jsonSerialize()
    {
        return [
            'sport' => $this->getSport(),
            'league' => $this->getLeague(),
            'matchDate' => $this->getMatchDate()->format('d.m.Y'),
            'language' => $this->getLanguage(),
            'team1' => $this->getTeam1(),
            'team2' => $this->getTeam2(),
            'source' => $this->getSource(),
            'createdAt' => $this->getSCreatedAt()->format('d.m.Y')
        ];
    }
}
