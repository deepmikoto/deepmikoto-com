<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamingPostView
 *
 * @ORM\Table(name="gaming_post_view")
 * @ORM\Entity
 */
class GamingPostView extends PostViewEntity
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

    /** set defaults */
    public function __construct()
    {
        parent::__construct();
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
}
