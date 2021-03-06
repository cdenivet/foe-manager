<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Level
 *
 * @ORM\Table(name="level")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LevelRepository")
 */
class Level
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
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="totalPF", type="integer")
     */
    private $totalPF;

    /**
     * @var int
     *
     * @ORM\Column(name="rewardP1", type="integer")
     */
    private $rewardP1;

    /**
     * @var int
     *
     * @ORM\Column(name="rewardP2", type="integer")
     */
    private $rewardP2;

    /**
     * @var int
     *
     * @ORM\Column(name="rewardP3", type="integer")
     */
    private $rewardP3;

    /**
     * @var int
     *
     * @ORM\Column(name="rewardP4", type="integer")
     */
    private $rewardP4;

    /**
     * @var int
     *
     * @ORM\Column(name="rewardP5", type="integer")
     */
    private $rewardP5;


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
     * Set level
     *
     * @param integer $level
     *
     * @return Level
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set totalPF
     *
     * @param integer $totalPF
     *
     * @return Level
     */
    public function setTotalPF($totalPF)
    {
        $this->totalPF = $totalPF;

        return $this;
    }

    /**
     * Get totalPF
     *
     * @return int
     */
    public function getTotalPF()
    {
        return $this->totalPF;
    }

    /**
     * Set rewardP1
     *
     * @param integer $rewardP1
     *
     * @return Level
     */
    public function setRewardP1($rewardP1)
    {
        $this->rewardP1 = $rewardP1;

        return $this;
    }

    /**
     * Get rewardP1
     *
     * @return int
     */
    public function getRewardP1()
    {
        return $this->rewardP1;
    }

    /**
     * Set rewardP2
     *
     * @param integer $rewardP2
     *
     * @return Level
     */
    public function setRewardP2($rewardP2)
    {
        $this->rewardP2 = $rewardP2;

        return $this;
    }

    /**
     * Get rewardP2
     *
     * @return int
     */
    public function getRewardP2()
    {
        return $this->rewardP2;
    }

    /**
     * Set rewardP3
     *
     * @param integer $rewardP3
     *
     * @return Level
     */
    public function setRewardP3($rewardP3)
    {
        $this->rewardP3 = $rewardP3;

        return $this;
    }

    /**
     * Get rewardP3
     *
     * @return int
     */
    public function getRewardP3()
    {
        return $this->rewardP3;
    }

    /**
     * Set rewardP4
     *
     * @param integer $rewardP4
     *
     * @return Level
     */
    public function setRewardP4($rewardP4)
    {
        $this->rewardP4 = $rewardP4;

        return $this;
    }

    /**
     * Get rewardP4
     *
     * @return int
     */
    public function getRewardP4()
    {
        return $this->rewardP4;
    }

    /**
     * Set rewardP5
     *
     * @param integer $rewardP5
     *
     * @return Level
     */
    public function setRewardP5($rewardP5)
    {
        $this->rewardP5 = $rewardP5;

        return $this;
    }

    /**
     * Get rewardP5
     *
     * @return int
     */
    public function getRewardP5()
    {
        return $this->rewardP5;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Gm", inversedBy="levels")
     * @ORM\JoinColumn(name="gm_id", referencedColumnName="id")
     */
    private $gm;

    /**
     * Set gm
     *
     * @param Gm $gm
     *
     * @return Level
     */
    public function setGm(Gm $gm = null)
    {
        $this->gm = $gm;

        return $this;
    }

    /**
     * Get gm
     *
     * @return Gm
     */
    public function getGm()
    {
        return $this->gm;
    }
}
