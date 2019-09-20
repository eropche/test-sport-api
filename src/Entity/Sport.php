<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 */
class Sport
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
     * @ORM\OneToMany(targetEntity="League", mappedBy="sport")
     */
    protected $leagues;
    
    /**
     * @ORM\OneToMany(targetEntity="Team", mappedBy="sport")
     */
    protected $teams;
    
    public function __construct()
    {
        $this->leagues = new ArrayCollection();
        $this->teams   = new ArrayCollection();
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
    
    public function getLeagues(): ?ArrayCollection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        $this->leagues->add($league);

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
