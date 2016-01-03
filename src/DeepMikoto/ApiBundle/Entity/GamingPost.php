<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GamingPost
 *
 * @ORM\Table(name="gaming_post")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class GamingPost
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
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255)
     */
    private $cover;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\OneToMany(targetEntity="DeepMikoto\ApiBundle\Entity\GamingPostView", mappedBy="post", cascade={"remove"})
     */
    private $views;

    /** variables and methods for handling file uploads */

    /**
     * @Assert\Image(
     *  allowPortrait = true
     * )
     */
    private $file;

    private $temp;

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'images/gaming/' . $this->id;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->cover
            ? null
            : $this->getUploadRootDir().'/'.$this->cover;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->cover
            ? null
            : $this->getUploadDir() . '/' . $this->cover;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if ( isset($this->cover) ) {
            $this->temp = $this->cover;
            $this->cover = null;
        } else {
            $this->cover = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ( null !== $this->getFile() ){
            $filename = 'gaming_' . sha1( uniqid( mt_rand(), true ) ) . '_' . microtime( true );
            $this->cover = $filename.'.'.$this->getFile()->getClientOriginalExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move( $this->getUploadRootDir(), $this->cover );
        if (isset( $this->temp )) {
            unlink( $this->getUploadRootDir().'/'.$this->temp );
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ( $file ) {
            unlink( $file );
        }
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->setDate( new \DateTime() );
    }

    /**
     * set defaults
     */
    public function __construct(){
        $this->views = new ArrayCollection();
        $this->setPublic( false );
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
     * @return GamingPost
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
     * Set slug
     *
     * @param string $slug
     * @return GamingPost
     */
    public function setSlug($slug)
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
     * Set date
     *
     * @param \DateTime $date
     * @return GamingPost
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
     * Set cover
     *
     * @param string $cover
     * @return GamingPost
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return GamingPost
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return CodingPost
     */
    public function setPublic($public)
    {
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
     * Add views
     *
     * @param \DeepMikoto\ApiBundle\Entity\GamingPostView $views
     * @return GamingPost
     */
    public function addView(GamingPostView $views)
    {
        $this->views[] = $views;

        return $this;
    }

    /**
     * Remove views
     *
     * @param \DeepMikoto\ApiBundle\Entity\GamingPostView $views
     */
    public function removeView(GamingPostView $views)
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
