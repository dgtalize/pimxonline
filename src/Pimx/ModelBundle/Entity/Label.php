<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Label
 */
class Label
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


    /**
     * Set id
     *
     * @param integer $id
     * @return Label
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
     * Set name
     *
     * @param string $name
     * @return Label
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Pimx\ModelBundle\Entity\Label
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add children
     *
     * @param \Pimx\ModelBundle\Entity\Label $children
     * @return Label
     */
    public function addChildren(\Pimx\ModelBundle\Entity\Label $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Pimx\ModelBundle\Entity\Label $children
     */
    public function removeChildren(\Pimx\ModelBundle\Entity\Label $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Pimx\ModelBundle\Entity\Label $parent
     * @return Label
     */
    public function setParent(\Pimx\ModelBundle\Entity\Label $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pimx\ModelBundle\Entity\Label 
     */
    public function getParent()
    {
        return $this->parent;
    }
}