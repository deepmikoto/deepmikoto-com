<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Eventviva\ImageResize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\JoinColumn(name="photography_post", referencedColumnName="id")
     */
    private $photographyPost;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @ORM\OneToMany(targetEntity="DeepMikoto\ApiBundle\Entity\PhotographyPostPhotoDownload", mappedBy="photographyPostPhoto", cascade={"remove"})
     */
    private $downloads;

    /**
     * @Assert\File(maxSize="10000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="alt_text", type="string", length=255)
     */
    private $altText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    private $temp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->downloads = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @return null|string
     */
    public function getOriginalFileAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'. 'original_' . $this->path;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * @return null|string
     */
    public function getOriginalFileWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.'original_' . $this->path;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'images/photography/' . $this->id;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if ( isset($this->path) ) {
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
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
            $this->path = $this->getFile()->getClientOriginalName();
            //$this->path = $filename.'.'.$this->getFile()->getClientOriginalExtension();
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
        try {
            $this->getFile()->move( $this->getUploadRootDir(), 'original_' . $this->path );
            $resizedImage = new ImageResize( $this->getUploadRootDir() . '/' . 'original_' . $this->path );
            $resizedImage->resizeToBestFit( 1920, 1080 );
            $resizedImage->save( $this->getUploadRootDir() . '/' . $this->path );
            if (isset( $this->temp )) {
                unlink( $this->getUploadRootDir().'/'.$this->temp );
                $this->temp = null;
            }
            $this->file = null;
        } catch ( \Exception $e ) {
            // let it be :)
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ( $file && file_exists( $file ) && is_file( $file ) ) {
            unlink( $file );
        }
        $originalFile = $this->getOriginalFileAbsolutePath();
        if ( $originalFile && file_exists( $originalFile ) && is_file( $originalFile ) ) {
            unlink( $originalFile );
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

    /**
     * Add downloads
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostPhotoDownload $downloads
     * @return PhotographyPostPhoto
     */
    public function addDownload(PhotographyPostPhotoDownload $downloads)
    {
        $this->downloads[] = $downloads;

        return $this;
    }

    /**
     * Remove downloads
     *
     * @param \DeepMikoto\ApiBundle\Entity\PhotographyPostPhotoDownload $downloads
     */
    public function removeDownload(PhotographyPostPhotoDownload $downloads)
    {
        $this->downloads->removeElement($downloads);
    }

    /**
     * Get downloads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * Set altText
     *
     * @param string $altText
     *
     * @return PhotographyPostPhoto
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText
     *
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }
}
