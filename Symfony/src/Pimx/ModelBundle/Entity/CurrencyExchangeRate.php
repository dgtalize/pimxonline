<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyExchangeRate
 */
class CurrencyExchangeRate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var float
     */
    private $rate;

    /**
     * @var \Pimx\ModelBundle\Entity\Currency
     */
    private $currency;


    /**
     * Set id
     *
     * @param integer $id
     * @return CurrencyExchangeRate
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return CurrencyExchangeRate
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return CurrencyExchangeRate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set currency
     *
     * @param \Pimx\ModelBundle\Entity\Currency $currency
     * @return CurrencyExchangeRate
     */
    public function setCurrency(\Pimx\ModelBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return \Pimx\ModelBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}