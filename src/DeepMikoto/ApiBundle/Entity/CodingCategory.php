<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * CodingCategory
 *
 * @ORM\Table(name="coding_category")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class CodingCategory
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="DeepMikoto\ApiBundle\Entity\CodingPost", mappedBy="categories")
     */
    private $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50)
     */
    private $slug;

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
        return 'images/coding/categories/' . $this->id;
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
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->image
            ? null
            : $this->getUploadDir() . '/' . $this->image;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if ( isset($this->image) ) {
            $this->temp = $this->image;
            $this->image = null;
        } else {
            $this->image = 'initial';
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
            $filename = 'cc_' . sha1( uniqid( mt_rand(), true ) ) . '_' . microtime( true );
            $this->image = $filename.'.'.$this->getFile()->getClientOriginalExtension();
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
        $this->getFile()->move( $this->getUploadRootDir(), $this->image );
        if (isset( $this->temp )) {
            unlink( $this->getUploadRootDir().'/'.$this->temp );
            $this->temp = null;
        }
        $this->file = null;
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
        $this->setCreated( new \DateTime() );
    }

    /**
     * define name property as unique
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint( new UniqueEntity([
                'fields'    => [ 'name' ],
                'message'   => 'This name is already in use!',
            ])
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return CodingCategory
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setSlug( $name );

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CodingCategory
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Add posts
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingPost $posts
     * @return CodingCategory
     */
    public function addPost(CodingPost $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingPost $posts
     */
    public function removePost(CodingPost $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return CodingCategory
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CodingCategory
     */
    public function setSlug($slug)
    {
        $this->slug = strtolower(
            str_replace( ' ', '-',
                trim(
                    preg_replace( '/\s+/', ' ',
                        preg_replace( "/[^A-Za-z0-9 ]/", '', $slug )
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
}
