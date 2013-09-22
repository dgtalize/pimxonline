<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movement
 */
class Movement {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $inputdate;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \Pimx\ModelBundle\Entity\MovementGroup
     */
    private $group;

    /**
     * @var \Pimx\ModelBundle\Entity\MovementType
     */
    private $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Movement
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Movement
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set inputdate
     *
     * @param \DateTime $inputdate
     * @return Movement
     */
    public function setInputdate($inputdate) {
        $this->inputdate = $inputdate;

        return $this;
    }

    /**
     * Get inputdate
     *
     * @return \DateTime 
     */
    public function getInputdate() {
        return $this->inputdate;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Movement
     */
    public function setNotes($notes) {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Set group
     *
     * @param \Pimx\ModelBundle\Entity\MovementGroup $group
     * @return Movement
     */
    public function setGroup(\Pimx\ModelBundle\Entity\MovementGroup $group = null) {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Pimx\ModelBundle\Entity\MovementGroup 
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * Set type
     *
     * @param \Pimx\ModelBundle\Entity\MovementType $type
     * @return Movement
     */
    public function setType(\Pimx\ModelBundle\Entity\MovementType $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Pimx\ModelBundle\Entity\MovementType 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $appliedAccounts;

    /**
     * Constructor
     */
    public function __construct() {
        $this->appliedAccounts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add appliedAccounts
     *
     * @param \Pimx\ModelBundle\Entity\MovementAccount $appliedAccounts
     * @return Movement
     */
    public function addAppliedAccount(\Pimx\ModelBundle\Entity\MovementAccount $appliedAccounts) {
        $appliedAccounts->setMovement($this);
        $this->appliedAccounts[] = $appliedAccounts;

        return $this;
    }

    /**
     * Remove appliedAccounts
     *
     * @param \Pimx\ModelBundle\Entity\MovementAccount $appliedAccounts
     */
    public function removeAppliedAccount(\Pimx\ModelBundle\Entity\MovementAccount $appliedAccounts) {
        $this->appliedAccounts->removeElement($appliedAccounts);
    }

    /**
     * Get appliedAccounts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAppliedAccounts() {
        return $this->appliedAccounts;
    }

    /**
     * Get inTotal
     *
     * @return float 
     */
    public function getInTotal() {
        $total = 0.0;
        foreach ($this->getAppliedAccounts() as $appliedAccount) {
            if ($appliedAccount->getSign() > 0) {
                $total += $appliedAccount->getAmount();
            }
        }

        return $total;
    }

    /**
     * Get outTotal
     *
     * @return float 
     */
    public function getOutTotal() {
        $total = 0.0;
        foreach ($this->appliedAccounts as $appliedAccount) {
            if ($appliedAccount->getSign() < 0) {
                $total += $appliedAccount->getAmount();
            }
        }

        return $total;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $groups;


    /**
     * Add groups
     *
     * @param \Pimx\ModelBundle\Entity\Label $groups
     * @return Movement
     */
    public function addGroup(\Pimx\ModelBundle\Entity\Label $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Pimx\ModelBundle\Entity\Label $groups
     */
    public function removeGroup(\Pimx\ModelBundle\Entity\Label $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}