<?php
/**
 * Created by PhpStorm.
 * User: caoych
 * Date: 2017/2/24
 * Time: 23:33
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
class User
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid", nullable=false )
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var Assert\Email
     *
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    private $email;


    private $password;

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
     * @return Assert\Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Assert\Email $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}