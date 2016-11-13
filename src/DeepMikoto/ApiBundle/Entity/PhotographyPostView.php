<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotographyPostView
 *
 * @ORM\Table(name="photography_post_view")
 * @ORM\Entity
 */
class PhotographyPostView extends PostViewEntity
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
     * @ORM\ManyToOne(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPost", inversedBy="views")
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
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPost $post
     * @return PhotographyPostView
     */
    public function setPost(PhotographyPost $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \DeepMikoto\ApiBundle\Entity\PhotographyPost 
     */
    public function getPost()
    {
        return $this->post;
    }
}
