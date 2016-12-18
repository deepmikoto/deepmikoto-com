<?php

namespace DeepMikoto\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IPApiCall
 *
 * @ORM\Table(name="ip_api_call")
 * @ORM\Entity()
 */
class IPApiCall
{
    const SUCCESS_STATUS = 'success';
    const FAILED_STATUS = 'fail';

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
     * @ORM\Column(name="ip", type="string", length=20)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="called_at", type="datetime")
     */
    private $calledAt;

    /**
     * @var array
     *
     * @ORM\Column(name="error_response", type="array")
     */
    private $errorResponse;

    /**
     * defaults
     * @param null $ip
     */
    public function __construct( $ip = null )
    {
        $this->setIp( $ip );
        $this->setStatus( self::SUCCESS_STATUS );
        $this->setCalledAt(new \DateTime());
        $this->setErrorResponse([]);
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
     * Set ip
     *
     * @param string $ip
     *
     * @return IPApiCall
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
     * Set status
     *
     * @param string $status
     *
     * @return IPApiCall
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set calledAt
     *
     * @param \DateTime $calledAt
     *
     * @return IPApiCall
     */
    public function setCalledAt($calledAt)
    {
        $this->calledAt = $calledAt;

        return $this;
    }

    /**
     * Get calledAt
     *
     * @return \DateTime
     */
    public function getCalledAt()
    {
        return $this->calledAt;
    }

    /**
     * Set errorResponse
     *
     * @param array $errorResponse
     *
     * @return IPApiCall
     */
    public function setErrorResponse($errorResponse)
    {
        $this->errorResponse = $errorResponse;

        return $this;
    }

    /**
     * Get errorResponse
     *
     * @return array
     */
    public function getErrorResponse()
    {
        return $this->errorResponse;
    }
}

