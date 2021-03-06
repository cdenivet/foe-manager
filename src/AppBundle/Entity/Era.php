<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Era
 *
 * @ORM\Table(name="era")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EraRepository")
 */
class Era
{
    // trait doctrine behaviors
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Gm", mappedBy="era")
     */
    private $gms;

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
     * Add gm
     *
     * @param Gm $gm
     *
     * @return Era
     */
    public function addGm(Gm $gm)
    {
        $this->gms[] = $gm;

        return $this;
    }

    /**
     * Remove gm
     *
     * @param Gm $gm
     */
    public function removeGm(Gm $gm)
    {
        $this->gms->removeElement($gm);
    }

    /**
     * Get gms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGms()
    {
        return $this->gms;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gms = new ArrayCollection();
    }

}
