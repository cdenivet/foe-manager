<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Gm
 *
 * @ORM\Table(name="gm")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GmRepository")
 */
class Gm
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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Era", inversedBy="gms")
     * @ORM\JoinColumn(name="era_id", referencedColumnName="id")
     */
    private $era;

    /**
     * @ORM\OneToMany(targetEntity="Level", mappedBy="gm")
     */
    private $levels;

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
     * Set era
     *
     * @param Era $era
     *
     * @return GM
     */
    public function setEra(Era $era = null)
    {
        $this->era = $era;

        return $this;
    }

    /**
     * Get era
     *
     * @return Era
     */
    public function getEra()
    {
        return $this->era;
    }

    /**
     * Add level
     *
     * @param Level $level
     *
     * @return Gm
     */
    public function addLevel(Level $level)
    {
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param Level $level
     */
    public function removeLevel(Level $level)
    {
        $this->levels->removeElement($level);
    }

    /**
     * Get levels
     *
     * @return Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new ArrayCollection();
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Gm
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
