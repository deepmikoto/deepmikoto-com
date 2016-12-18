<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 11/13/2016
 * Time: 15:28
 */

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class TrackingEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50)
     */
    private $ip;

    /**
     * @var array
     *
     * @ORM\Column(name="user_browser_data", type="array")
     */
    private $userBrowserData;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_ip_data", type="boolean")
     */
    private $hasIpData;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_data", type="array")
     */
    private $ipData;

    /**
     * defaults
     */
    public function __construct()
    {
        $this->setUserBrowserData([]);
        $this->setHasIpData( false );
        $this->setIpData([]);
    }
    /**
     * Set ip
     *
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return array
     */
    public function getUserBrowserData()
    {
        return $this->userBrowserData;
    }

    /**
     * @param array $userBrowserData
     * @return $this
     */
    public function setUserBrowserData($userBrowserData)
    {
        $this->userBrowserData = $userBrowserData;

        return $this;
    }

    /**
     * Set hasIpData
     *
     * @param boolean $hasIpData
     *
     * @return TrackingEntity
     */
    public function setHasIpData($hasIpData)
    {
        $this->hasIpData = $hasIpData;

        return $this;
    }

    /**
     * Get hasIpData
     *
     * @return boolean
     */
    public function getHasIpData()
    {
        return $this->hasIpData;
    }

    /**
     * Set ipData
     *
     * @param array $ipData
     *
     * @return TrackingEntity
     */
    public function setIpData($ipData)
    {
        $this->ipData = $ipData;

        return $this;
    }

    /**
     * Get ipData
     *
     * @return array
     */
    public function getIpData()
    {
        return $this->ipData;
    }
}
