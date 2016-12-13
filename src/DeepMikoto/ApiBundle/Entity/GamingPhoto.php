<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GamingPhoto
 *
 * @ORM\Table(name="gaming_photo")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class GamingPhoto
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @Assert\File(maxSize="15000000")
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    private $temp;

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
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
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
        return 'images/gaming/' . $this->id;
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
            $this->getFile()->move( $this->getUploadRootDir(), $this->path );
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
     * @return GamingPhoto
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
     * @return GamingPhoto
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
