<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotographyPostPhoto
 *
 * @ORM\Table(name="photography_post_photo")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PhotographyPostPhoto
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
     * @ORM\ManyToOne(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPost", inversedBy="photos")
     * @ORM\JoinColumn(name="news_post", referencedColumnName="id")
     */
    private $photographyPost;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
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
     * Set path
     *
     * @param string $path
     * @return PhotographyPostPhoto
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PhotographyPostPhoto
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
     * Set photographyPost
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPost $photographyPost
     * @return PhotographyPostPhoto
     */
    public function setPhotographyPost(PhotographyPost $photographyPost = null)
    {
        $this->photographyPost = $photographyPost;

        return $this;
    }

    /**
     * Get photographyPost
     *
     * @return \DeepMikoto\ApiBundle\Entity\PhotographyPost 
     */
    public function getPhotographyPost()
    {
        return $this->photographyPost;
    }
}
