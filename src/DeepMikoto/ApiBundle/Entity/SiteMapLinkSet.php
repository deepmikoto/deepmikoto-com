<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteMapLinkSet
 *
 * @ORM\Table(name="sitemap_link_set")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class SiteMapLinkSet
{
    const CODING_POST_TYPE = 'coding_post';
    const CODING_CATEGORY_TYPE = 'coding_category';
    const GAMING_POST_TYPE = 'gaming_post';
    const PHOTOGRAPHY_POST_TYPE = 'photography_post';

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
     * @ORM\Column(name="set_type", type="string", length=20)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=50)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_scope", type="datetime", nullable=true)
     */
    private $dateScope;

    /**
     * @var integer
     *
     * @ORM\Column(name="link_count", type="integer")
     */
    private $linkCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="first_reference_id", type="integer", nullable=true)
     */
    private $firstReferenceId;

    /**
     * @param null $type
     */
    public function __construct( $type = null )
    {
        $this->setType( $type );
        $this->setCreatedAt( new \DateTime() );
        $this->setUpdatedAt( new \DateTime() );
        $this->setLinkCount( 0 );
        $this->setDateScope( null );
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdatedAt( new \DateTime() );
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
     * @return SiteMapLinkSet
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SiteMapLinkSet
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return SiteMapLinkSet
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set linkCount
     *
     * @param integer $linkCount
     * @return SiteMapLinkSet
     */
    public function setLinkCount($linkCount)
    {
        $this->linkCount = $linkCount;

        return $this;
    }

    /**
     * Get linkCount
     *
     * @return integer 
     */
    public function getLinkCount()
    {
        return $this->linkCount;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SiteMapLinkSet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateScope
     *
     * @param \DateTime $dateScope
     * @return SiteMapLinkSet
     */
    public function setDateScope($dateScope)
    {
        $this->dateScope = $dateScope;

        return $this;
    }

    /**
     * Get dateScope
     *
     * @return \DateTime 
     */
    public function getDateScope()
    {
        return $this->dateScope;
    }

    /**
     * Set firstReferenceId
     *
     * @param integer $firstReferenceId
     * @return SiteMapLinkSet
     */
    public function setFirstReferenceId($firstReferenceId)
    {
        $this->firstReferenceId = $firstReferenceId;

        return $this;
    }

    /**
     * Get firstReferenceId
     *
     * @return integer 
     */
    public function getFirstReferenceId()
    {
        return $this->firstReferenceId;
    }
}
