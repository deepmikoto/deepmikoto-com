<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotographyPostPhotoDownload
 *
 * @ORM\Table(name="photography_post_photo_download")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PhotographyPostPhotoDownload extends TrackingEntity
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
     * @ORM\ManyToOne(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto", inversedBy="downloads")
     * @ORM\JoinColumn(name="photography_post_photo", referencedColumnName="id")
     */
    private $photographyPostPhoto;

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
     * Set date
     *
     * @param \DateTime $date
     * @return PhotographyPostPhotoDownload
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
     * Set photographyPostPhoto
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto $photographyPostPhoto
     * @return PhotographyPostPhotoDownload
     */
    public function setPhotographyPostPhoto(PhotographyPostPhoto $photographyPostPhoto = null)
    {
        $this->photographyPostPhoto = $photographyPostPhoto;

        return $this;
    }

    /**
     * Get photographyPostPhoto
     *
     * @return \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto 
     */
    public function getPhotographyPostPhoto()
    {
        return $this->photographyPostPhoto;
    }
}
