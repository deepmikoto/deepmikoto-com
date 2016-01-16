<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PhotographyPost
 *
 * @ORM\Table(name="photography_post")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PhotographyPost
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto", mappedBy="photographyPost", cascade={"remove"})
     */
    private $photos;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\OneToMany(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPostView", mappedBy="post", cascade={"remove"})
     */
    private $views;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->views = new ArrayCollection();
        $this->setPublic( false );
    }

    /**
     * string representation of the entity, used in forms
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

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
     * Set title
     *
     * @param string $title
     * @return PhotographyPost
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PhotographyPost
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
     * Set location
     *
     * @param string $location
     * @return PhotographyPost
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add photos
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto $photos
     * @return PhotographyPost
     */
    public function addPhoto(PhotographyPostPhoto $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto $photos
     */
    public function removePhoto(PhotographyPostPhoto $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return PhotographyPost
     */
    public function setPublic($public)
    {
        $this->setDate( new \DateTime() );
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return PhotographyPost
     */
    public function setSlug( $slug )
    {
        $this->slug = strtolower(
            trim(
                str_replace( ' ', '-',
                    trim(
                        preg_replace( '/\s+/', ' ',
                            preg_replace( "/[^A-Za-z0-9 ]/", '', $slug )
                        )
                    )
                )
            )
        );

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add views
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostView $views
     * @return PhotographyPost
     */
    public function addView(PhotographyPostView $views)
    {
        $this->views[] = $views;

        return $this;
    }

    /**
     * Remove views
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostView $views
     */
    public function removeView(PhotographyPostView $views)
    {
        $this->views->removeElement($views);
    }

    /**
     * Get views
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getViews()
    {
        return $this->views;
    }
}
