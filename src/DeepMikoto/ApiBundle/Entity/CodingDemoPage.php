<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CodingDemoPage
 *
 * @ORM\Table(name="coding_demo_page")
 * @ORM\Entity()
 */
class CodingDemoPage
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
     * @ORM\OneToOne(targetEntity="DeepMikoto\ApiBundle\Entity\CodingPost")
     * @ORM\JoinColumn(name="coding_post", referencedColumnName="id")
     */
    private $codingPost;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="text", nullable=true)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text", nullable=true)
     */
    private $html;

    /**
     * @var string
     *
     * @ORM\Column(name="js", type="text", nullable=true)
     */
    private $js;

    /**
     * @ORM\OneToMany(targetEntity="DeepMikoto\ApiBundle\Entity\CodingDemoPageView", mappedBy="demoPage", cascade={"remove"})
     */
    private $views;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->setDate(new \DateTime());
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
     *
     * @return CodingDemoPage
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
     *
     * @return CodingDemoPage
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
     * Set style
     *
     * @param string $style
     *
     * @return CodingDemoPage
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set html
     *
     * @param string $html
     *
     * @return CodingDemoPage
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set js
     *
     * @param string $js
     *
     * @return CodingDemoPage
     */
    public function setJs($js)
    {
        $this->js = $js;

        return $this;
    }

    /**
     * Get js
     *
     * @return string
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Set codingPost
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingPost $codingPost
     *
     * @return CodingDemoPage
     */
    public function setCodingPost(CodingPost $codingPost = null)
    {
        $this->codingPost = $codingPost;

        return $this;
    }

    /**
     * Get codingPost
     *
     * @return \DeepMikoto\ApiBundle\Entity\CodingPost
     */
    public function getCodingPost()
    {
        return $this->codingPost;
    }

    /**
     * Add view
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingDemoPageView $view
     *
     * @return CodingDemoPage
     */
    public function addView(CodingDemoPageView $view)
    {
        $this->views[] = $view;

        return $this;
    }

    /**
     * Remove view
     *
     * @param \DeepMikoto\ApiBundle\Entity\CodingDemoPageView $view
     */
    public function removeView(CodingDemoPageView $view)
    {
        $this->views->removeElement($view);
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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CodingDemoPage
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
