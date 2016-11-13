<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 11/13/2016
 * Time: 16:08
 */

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class PostViewEntity extends TrackingEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="referer_domain", type="string", nullable=true, length=100)
     */
    private $refererDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="referer_url", type="string", nullable=true, length=100)
     */
    private $refererUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * defaults
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDate( new \DateTime() );
    }

    /**
     * Set refererDomain
     *
     * @param string $refererDomain
     * @return CodingPostView
     */
    public function setRefererDomain($refererDomain)
    {
        $this->refererDomain = $refererDomain;

        return $this;
    }

    /**
     * Get refererDomain
     *
     * @return string
     */
    public function getRefererDomain()
    {
        return $this->refererDomain;
    }

    /**
     * Set refererUrl
     *
     * @param string $refererUrl
     * @return $this
     */
    public function setRefererUrl($refererUrl)
    {
        $this->refererUrl = $refererUrl;

        return $this;
    }

    /**
     * Get refererUrl
     *
     * @return string
     */
    public function getRefererUrl()
    {
        return $this->refererUrl;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return $this
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