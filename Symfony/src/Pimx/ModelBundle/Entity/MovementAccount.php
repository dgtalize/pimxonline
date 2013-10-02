<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovementAccount
 */
class MovementAccount
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var integer
     */
    private $sign;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \Pimx\ModelBundle\Entity\Account
     */
    private $account;

    /**
     * @var \Pimx\ModelBundle\Entity\Movement
     */
    private $movement;


    /**
     * Set code
     *
     * @param string $code
     * @return MovementAccount
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set sign
     *
     * @param integer $sign
     * @return MovementAccount
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    
        return $this;
    }

    /**
     * Get sign
     *
     * @return integer 
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return MovementAccount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set account
     *
     * @param \Pimx\ModelBundle\Entity\Account $account
     * @return MovementAccount
     */
    public function setAccount(\Pimx\ModelBundle\Entity\Account $account = null)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return \Pimx\ModelBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }


    /**
     * Set movement
     *
     * @param \Pimx\ModelBundle\Entity\Movement $movement
     * @return MovementAccount
     */
    public function setMovement(\Pimx\ModelBundle\Entity\Movement $movement)
    {
        $this->movement = $movement;
    
        return $this;
    }

    /**
     * Get movement
     *
     * @return \Pimx\ModelBundle\Entity\Movement 
     */
    public function getMovement()
    {
        return $this->movement;
    }
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}