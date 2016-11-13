<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PushNotificationSubscription
 *
 * @ORM\Table(name="push_notification_subscription")
 * @ORM\Entity()
 */
class PushNotificationSubscription
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
     * @var string
     *
     * @ORM\Column(name="endpoint", type="string", length=500)
     */
    private $endpoint;

    /**
     * @var string
     *
     * @ORM\Column(name="user_public_key", type="string", length=255)
     */
    private $userPublicKey;

    /**
     * @var string
     *
     * @ORM\Column(name="user_auth_token", type="string", length=255)
     */
    private $userAuthToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var array
     *
     * @ORM\Column(name="user_browser_data", type="array")
     */
    private $userBrowserData;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50)
     */
    private $ip;

    /**
     * defaults
     */
    public function __construct()
    {
        $this->setCreatedAt( new \DateTime() );
        $this->setUserBrowserData([]);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set endpoint
     *
     * @param string $endpoint
     *
     * @return PushNotificationSubscription
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set userPublicKey
     *
     * @param string $userPublicKey
     *
     * @return PushNotificationSubscription
     */
    public function setUserPublicKey($userPublicKey)
    {
        $this->userPublicKey = $userPublicKey;

        return $this;
    }

    /**
     * Get userPublicKey
     *
     * @return string
     */
    public function getUserPublicKey()
    {
        return $this->userPublicKey;
    }

    /**
     * Set userAuthToken
     *
     * @param string $userAuthToken
     *
     * @return PushNotificationSubscription
     */
    public function setUserAuthToken($userAuthToken)
    {
        $this->userAuthToken = $userAuthToken;

        return $this;
    }

    /**
     * Get userAuthToken
     *
     * @return string
     */
    public function getUserAuthToken()
    {
        return $this->userAuthToken;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PushNotificationSubscription
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
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }
}

