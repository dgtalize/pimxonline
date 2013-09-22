<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovementType
 */
class MovementType
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
     * Set codigo
     *
     * @param string $codigo
     * @return MovementType
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
     * @return MovementType
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
}