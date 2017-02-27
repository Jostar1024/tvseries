<?php

namespace CAO\TvSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Episode
 *
 * @author CAO Yucheng howard.eureka@gmail.com
 *
 * @package TvSeriesBundle\Entity
 *
 * @ORM\Entity
 *
 */
class Episode
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="guid", nullable=false)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     *
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $episodeNumber;

    /** @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePublished;

    /** @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={"image/*"})
     */
    private $image;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getEpisodeNumber()
    {
        return $this->episodeNumber;
    }

    /**
     * @param int $episodeNumber
     */
    public function setEpisodeNumber($episodeNumber)
    {
        $this->episodeNumber = $episodeNumber;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param \DateTimeInterface $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getTvSeries()
    {
        return $this->tvSeries;
    }

    /**
     * @param mixed $tvSeries
     */
    public function setTvSeries($tvSeries)
    {
        $this->tvSeries = $tvSeries;
    }

    /**
     * Many Episodes have one TvSeries.
     * @ORM\ManyToOne(targetEntity="CAO\TvSeriesBundle\Entity\TvSeries")
     * @ORM\JoinColumn(name="tvSeriesId",referencedColumnName="id")
     */
    private $tvSeries;


}