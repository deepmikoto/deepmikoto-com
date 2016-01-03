<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamingPostView
 *
 * @ORM\Table(name="gaming_post_view")
 * @ORM\Entity
 */
class GamingPostView
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="DeepMikoto\ApiBundle\Entity\GamingPost", inversedBy="views")
     * @ORM\JoinColumn(name="post", referencedColumnName="id")
     */
    private $post;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=50)
     */
    private $browser;

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


    /** set defaults */
    public function __construct()
    {
        $this->setDate( new \DateTime() );
    }

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
     * Set ip
     *
     * @param string $ip
     * @return GamingPostView
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set browser
     *
     * @param string $browser
     * @return GamingPostView
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return GamingPostView
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


    /**
     * Set post
     *
     * @param \DeepMikoto\ApiBundle\Entity\GamingPost $post
     * @return GamingPostView
     */
    public function setPost(GamingPost $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \DeepMikoto\ApiBundle\Entity\GamingPost 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set refererDomain
     *
     * @param string $refererDomain
     * @return GamingPostView
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
     * @return GamingPostView
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
}
