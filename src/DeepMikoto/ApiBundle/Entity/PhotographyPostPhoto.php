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
     * @Assert\File(maxSize="15000000")
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

    /**
     * @var string
     *
     * @ORM\Column(name="camera", type="string", length=50, nullable=true)
     */
    private $camera;

    /**
     * @var string
     *
     * @ORM\Column(name="exposure", type="string", length=20, nullable=true)
     */
    private $exposure;

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", length=10, nullable=true)
     */
    private $iso;

    /**
     * @var string
     *
     * @ORM\Column(name="aperture", type="string", length=10, nullable=true)
     */
    private $aperture;

    /**
     * @var string
     *
     * @ORM\Column(name="focal_length", type="string", length=15, nullable=true)
     */
    private $focalLength;

    /**
     * @var string
     *
     * @ORM\Column(name="resolution", type="string", length=20, nullable=true)
     */
    private $resolution;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_taken", type="date", nullable=true)
     */
    private $dateTaken;

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

    /**
     * Set camera
     *
     * @param string $camera
     *
     * @return PhotographyPostPhoto
     */
    public function setCamera($camera)
    {
        $this->camera = $camera;

        return $this;
    }

    /**
     * Get camera
     *
     * @return string
     */
    public function getCamera()
    {
        return $this->camera;
    }

    /**
     * Set exposure
     *
     * @param string $exposure
     *
     * @return PhotographyPostPhoto
     */
    public function setExposure($exposure)
    {
        $this->exposure = $exposure;

        return $this;
    }

    /**
     * Get exposure
     *
     * @return string
     */
    public function getExposure()
    {
        return $this->exposure;
    }

    /**
     * Set iso
     *
     * @param string $iso
     *
     * @return PhotographyPostPhoto
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Set aperture
     *
     * @param string $aperture
     *
     * @return PhotographyPostPhoto
     */
    public function setAperture($aperture)
    {
        $this->aperture = $aperture;

        return $this;
    }

    /**
     * Get aperture
     *
     * @return string
     */
    public function getAperture()
    {
        return $this->aperture;
    }

    /**
     * Set focalLength
     *
     * @param string $focalLength
     *
     * @return PhotographyPostPhoto
     */
    public function setFocalLength($focalLength)
    {
        $this->focalLength = $focalLength;

        return $this;
    }

    /**
     * Get focalLength
     *
     * @return string
     */
    public function getFocalLength()
    {
        return $this->focalLength;
    }

    /**
     * Set resolution
     *
     * @param string $resolution
     *
     * @return PhotographyPostPhoto
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * Get resolution
     *
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Set dateTaken
     *
     * @param \DateTime $dateTaken
     *
     * @return PhotographyPostPhoto
     */
    public function setDateTaken($dateTaken)
    {
        $this->dateTaken = $dateTaken;

        return $this;
    }

    /**
     * Get dateTaken
     *
     * @return \DateTime
     */
    public function getDateTaken()
    {
        return $this->dateTaken;
    }
}
