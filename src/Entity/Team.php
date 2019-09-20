<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Sport", inversedBy="teams")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     */
    protected $sport;
    
    /**
     * games_home и games_guest тут особенно выглядел бы интересно
     * 
     * @ORM\OneToMany(targetEntity="Game", mappedBy="team1")
     */
    protected $games1;
    
    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="team2")
     */
    protected $games2;
    
    public function __construct()
    {
        $this->games1 = new ArrayCollection();
        $this->games2 = new ArrayCollection();
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
}
