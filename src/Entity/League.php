<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 */
class League
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Sport", inversedBy="leagues")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     */
    protected $sport;
    
    /**
     * @ORM\ManyToMany(targetEntity="Team")
     * @ORM\JoinTable(name="leagues_teams",
     *          joinColumns={@ORM\JoinColumn(name="league_id", referencedColumnName="id")},
     *          inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     *      )
     */
    protected $teams;
    
    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }
    
    public function getTeams(): ?ArrayCollection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        $this->teams->add($team);

        return $this;
    }
}
