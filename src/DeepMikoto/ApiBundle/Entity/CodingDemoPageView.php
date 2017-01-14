<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodingDemoPageView
 *
 * @ORM\Table(name="coding_demo_page_view")
 * @ORM\Entity()
 */
class CodingDemoPageView extends PostViewEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="DeepMikoto\ApiBundle\Entity\CodingDemoPage", inversedBy="views")
     * @ORM\JoinColumn(name="demo_page", referencedColumnName="id")
     */
    private $demoPage;

    /**
     * defaults
     */
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
     * Set demoPage
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingDemoPage $demoPage
     *
     * @return CodingDemoPageView
     */
    public function setDemoPage(CodingDemoPage $demoPage = null)
    {
        $this->demoPage = $demoPage;

        return $this;
    }

    /**
     * Get demoPage
     *
     * @return \DeepMikoto\ApiBundle\Entity\CodingDemoPage
     */
    public function getDemoPage()
    {
        return $this->demoPage;
    }
}
