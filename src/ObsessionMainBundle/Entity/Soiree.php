<?php

namespace ObsessionMainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Soiree
 *
 * @ORM\Table(name="soiree")
 * @ORM\Entity(repositoryClass="ObsessionMainBundle\Repository\SoireeRepository")
 */
class Soiree
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Lieu" , fetch="EAGER", inversedBy="soirees")
     */
    private $lieu;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Soiree
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Soiree
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }
    

    /**
     * Set lieu
     *
     * @param \ObsessionMainBundle\Entity\Lieu $lieu
     *
     * @return Soiree
     */
    public function setLieu(\ObsessionMainBundle\Entity\Lieu $lieu = null)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return \ObsessionMainBundle\Entity\Lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    function __toString()
    {
        if($this->theme == null)
            return $this->lieu->getVille().' - '.$this->date->format('d-m-Y');
        return $this->lieu->getVille().' - '.$this->date->format('d-m-Y').' - '.$this->theme;
    }
    
    public function isPass(){
        $date=new \DateTime();
        return ($this->date<$date)?true:false;
    }


}
