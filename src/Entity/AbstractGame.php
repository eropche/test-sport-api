<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperclass
 */
class AbstractGame 
{  
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="language", type="string")
     */
    protected $language;
   
    /**
     * @ORM\Column(name="match_date", type="datetime")
     */
    protected $matchDate;
    
    /**
     * @ORM\Column(name="source", type="string")
     */
    protected $source;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * Get id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Get language
     * @return string
     */
    public function getLanguage() 
    {
        return $this->language;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return AbstractEntity
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }
    
    /**
     * Get source
     * @return string
     */
    public function getSource() 
    {
        return $this->source;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return AbstractEntity
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }
    
    /**
     * Get matchDate
     * @return \DateTime
     */
    public function getMatchDate() 
    {
        return $this->matchDate;
    }

    /**
     * Set matchDate
     *
     * @param \DateTime $matchDate
     *
     * @return AbstractEntity
     */
    public function setMatchDate($matchDate)
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    /**
     * Get createdAt
     * @return \DateTime
     */
    public function getCreatedAt() 
    {
        return $this->createdAt;
    }
}
