<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game extends AbstractGame implements JsonSerializable
{
    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="games")
     * @ORM\JoinColumn(name="team1_id", referencedColumnName="id")
     */
    protected $team1;
    
   /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="games")
     * @ORM\JoinColumn(name="team2_id", referencedColumnName="id")
     */
    protected $team2;
    
    /**
     * @ORM\OneToMany(targetEntity="GameBuffer", mappedBy="game")
     */
    protected $gamesBuffer;
    
    public function __construct()
    {
        $this->createdAt   = new \DateTime();
        $this->gamesBuffer = new ArrayCollection();
    }
    
    /**
     * Get team1
     * @return Team
     */
    public function getTeam1(): Team
    {
        return $this->team1;
    }
    
    /**
     * Set team1
     *
     * @param Team $team1
     *
     * @return GameBuffer
     */
    public function setTeam1(Team $team1)
    {
        $this->team1 = $team1;

        return $this;
    }
    
    /**
     * Get team2
     * @return Team
     */
    public function getTeam2(): Team
    {
        return $this->team2;
    }
    
    /**
     * Set team2
     *
     * @param Team $team2
     *
     * @return GameBuffer
     */
    public function setTeam2(Team $team2)
    {
        $this->team2 = $team2;

        return $this;
    }
    
    public function getGamesBuffer(): ?ArrayCollection
    {
        return $this->gamesBuffer;
    }

    public function addGamesBuffer(GameBuffer $gamesBuffer): self
    {
        $this->gamesBuffer->add($gamesBuffer);

        return $this;
    }
    
    public function jsonSerialize()
    {
        return [
            'sport' => $this->getTeam1()->getSport(),
            'league' => $this->getTeam1()->getLeague(),
            'matchDate' => $this->getMatchDate()->format('d.m.Y'),
            'language' => $this->getLanguage(),
            'team1' => $this->getTeam1(),
            'team2' => $this->getTeam2(),
            'source' => $this->getSource(),
            'createdAt' => $this->getSCreatedAt()->format('d.m.Y'),
            'gamesBuffers' => $this->getGamesBuffer()->toArray(),
            'gamesBuffersCount' => $this->getGamesBuffer()->count()
        ];
    }
}
