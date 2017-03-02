<?php
/**
 * Created by PhpStorm.
 * User: caoych
 * Date: 2017/2/24
 * Time: 23:20
 */

namespace CAO\TvSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserEpisode
 *
 * @author CAO Yucheng howard.eureka@gmail.com
 *
 * @package TvSeriesBundle\Entity
 *
 * @ORM\Entity
 *
 */
class UserEpisode
{

    /**
     * Many Episodes -- One User
     * @ORM\ManyToOne(targetEntity="CAO\TvSeriesBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * @ORM\Id()
     */
    private $user;
    /**
     * Many Users -- One Episodes
     * @ORM\ManyToOne(targetEntity="CAO\TvSeriesBundle\Entity\Episode")
     * @ORM\JoinColumn(name="episodeId", referencedColumnName="id")
     * @ORM\Id()
     */
    private $episode;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $current;
    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $watechedAt;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * @param mixed $episode
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getWatechedAt()
    {
        return $this->watechedAt;
    }

    /**
     * @param \DateTimeInterface $watechedAt
     */
    public function setWatechedAt($watechedAt)
    {
        $this->watechedAt = $watechedAt;
    }

}
