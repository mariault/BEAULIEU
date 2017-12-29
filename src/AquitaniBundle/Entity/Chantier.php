<?php

namespace AquitaniBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chantier
 *
 * @ORM\Table(name="chantier")
 * @ORM\Entity(repositoryClass="AquitaniBundle\Repository\ChantierRepository")
 */
class Chantier
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedefin", type="datetime")
     */
    private $datedefin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     * 
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;
    /**
     * @ORM\ManyToOne(targetEntity="Activite")
     */
    private $activites;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Chantier
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
     * Set datedefin
     *
     * @param \DateTime $datedefin
     *
     * @return Chantier
     */
    public function setDatedefin($datedefin)
    {
        $this->datedefin = $datedefin;

        return $this;
    }

    /**
     * Get datedefin
     *
     * @return \DateTime
     */
    public function getDatedefin()
    {
        return $this->datedefin;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Chantier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Chantier
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    function getActivites() {
        return $this->activites;
    }

    function setActivites($activites) {
        $this->activites = $activites;
    }


}

