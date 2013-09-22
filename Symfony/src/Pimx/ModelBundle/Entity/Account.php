<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 */
class Account
{
    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $sign;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \Pimx\FrontendBundle\Entity\AccountGroup
     */
    private $group;

    /**
     * @var \Pimx\FrontendBundle\Entity\AccountType
     */
    private $type;


    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Account
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Account
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set sign
     *
     * @param integer $sign
     * @return Account
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
     * Set notes
     *
     * @param string $notes
     * @return Account
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set group
     *
     * @param \Pimx\ModelBundle\Entity\AccountGroup $group
     * @return Account
     */
    public function setGroup(\Pimx\ModelBundle\Entity\AccountGroup $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \Pimx\ModelBundle\Entity\AccountGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set type
     *
     * @param \Pimx\ModelBundle\Entity\AccountType $type
     * @return Account
     */
    public function setType(\Pimx\ModelBundle\Entity\AccountType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Pimx\ModelBundle\Entity\AccountType 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @var string
     */
    private $code;


    /**
     * Set code
     *
     * @param string $code
     * @return Account
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
}