<?php

namespace ObsessionMainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="lieu")
 * @ORM\Entity(repositoryClass="ObsessionMainBundle\Repository\LieuRepository")
 */
class Lieu
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
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     *
     * @ORM\OneToMany(targetEntity="Soiree" , fetch="EAGER", mappedBy="lieu")
     */
    private $soirees;



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
     * Set code
     *
     * @param integer $code
     * @return Lieu
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Lieu
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Lieu
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Lieu
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->soirees = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add soiree
     *
     * @param \ObsessionMainBundle\Entity\Soiree $soiree
     *
     * @return Lieu
     */
    public function addSoiree(\ObsessionMainBundle\Entity\Soiree $soiree)
    {
        $this->soirees[] = $soiree;

        return $this;
    }

    /**
     * Remove soiree
     *
     * @param \ObsessionMainBundle\Entity\Soiree $soiree
     */
    public function removeSoiree(\ObsessionMainBundle\Entity\Soiree $soiree)
    {
        $this->soirees->removeElement($soiree);
    }

    /**
     * Get soirees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoirees()
    {
        return $this->soirees;
    }

    function __toString()
    {
        return $this->nom.' - '.$this->adresse.' - '.$this->code.' - '.$this->ville;
    }


}
