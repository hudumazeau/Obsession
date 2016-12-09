<?php

namespace ObsessionMainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistique
 *
 * @ORM\Table(name="statistique")
 * @ORM\Entity(repositoryClass="ObsessionMainBundle\Repository\StatistiqueRepository")
 */
class Statistique
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
     * @ORM\Column(name="Accueil", type="integer")
     */
    private $accueil;

    /**
     * @var int
     *
     * @ORM\Column(name="Presentation", type="integer")
     */
    private $presentation;

    /**
     * @var int
     *
     * @ORM\Column(name="Photos", type="integer")
     */
    private $photos;

    /**
     * @var int
     *
     * @ORM\Column(name="Soirees", type="integer")
     */
    private $soirees;

    /**
     * @var int
     *
     * @ORM\Column(name="Contacts", type="integer")
     */
    private $contacts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accueil
     *
     * @param integer $accueil
     *
     * @return Statistique
     */
    public function setAccueil($accueil)
    {
        $this->accueil = $accueil;

        return $this;
    }

    /**
     * Get accueil
     *
     * @return int
     */
    public function getAccueil()
    {
        return $this->accueil;
    }

    /**
     * Set presentation
     *
     * @param integer $presentation
     *
     * @return Statistique
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return int
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set photos
     *
     * @param integer $photos
     *
     * @return Statistique
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photos
     *
     * @return int
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set soirees
     *
     * @param integer $soirees
     *
     * @return Statistique
     */
    public function setSoirees($soirees)
    {
        $this->soirees = $soirees;

        return $this;
    }

    /**
     * Get soirees
     *
     * @return int
     */
    public function getSoirees()
    {
        return $this->soirees;
    }

    /**
     * Set contacts
     *
     * @param integer $contacts
     *
     * @return Statistique
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Get contacts
     *
     * @return int
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Statistique
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
}

