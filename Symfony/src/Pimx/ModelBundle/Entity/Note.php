<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pimx\ModelBundle\Utilities\RtfConverter;
use Pimx\ModelBundle\Utilities\RtfToHtml;

/**
 * Note
 */
class Note
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
     * @var boolean
     */
    private $isEncrypted;

    /**
     * @var \DateTime
     */
    private $inputdate;

    /**
     * @var \DateTime
     */
    private $lastmodifdate;
    
    private $cryptPassword;

    /**
     * Set name
     *
     * @param string $name
     * @return Note
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
     * Set isEncrypted
     *
     * @param boolean $isEncrypted
     * @return Note
     */
    public function setIsEncrypted($isEncrypted)
    {
        $this->isEncrypted = $isEncrypted;
    
        return $this;
    }

    /**
     * Get isEncrypted
     *
     * @return boolean 
     */
    public function getIsEncrypted()
    {
        return $this->isEncrypted;
    }

    /**
     * Set inputdate
     *
     * @param \DateTime $inputdate
     * @return Note
     */
    public function setInputdate($inputdate)
    {
        $this->inputdate = $inputdate;
    
        return $this;
    }

    /**
     * Get inputdate
     *
     * @return \DateTime 
     */
    public function getInputdate()
    {
        return $this->inputdate;
    }

    /**
     * Set lastmodifdate
     *
     * @param \DateTime $lastmodifdate
     * @return Note
     */
    public function setLastmodifdate($lastmodifdate)
    {
        $this->lastmodifdate = $lastmodifdate;
    
        return $this;
    }

    /**
     * Get lastmodifdate
     *
     * @return \DateTime 
     */
    public function getLastmodifdate()
    {
        return $this->lastmodifdate;
    }
    /**
     * @var string
     */
    private $content;


    /**
     * Set content
     *
     * @param string $content
     * @return Note
     */
    public function setContent($content)
    {
        $this->content = $content;
        
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        $contentToReturn = $this->content;
        
        //decrypt, if it's necessary
        if($this->isEncrypted) {
            $contentToReturn = $this->decrypt($contentToReturn, $this->cryptPassword);
        }
        
        //check if it is RTF
        if( strpos($contentToReturn, '{\rtf') === 0 ){
            $rtfConverter = new RtfToHtml();
            $contentToReturn = $rtfConverter->convert($contentToReturn);
        }
        return $contentToReturn;
    }


    /**
     * Set id
     *
     * @param integer $id
     * @return Note
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
    
    public function setCryptPassword($password)
    {
        $this->cryptPassword = $password;
        return $this;
    }
    public function getCryptPassword()
    {
        return $this->cryptPassword;
    }
    
    private function decrypt($content, $password) {
        //$iv = array(80, 73, 77, 88, 84, 82, 69, 77, 69, 80, 73, 77, 88, 84, 82, 69);
        //$iv = base64_decode(str_pad("PIMXTREMEPIMXTRE", 256, " ", STR_PAD_RIGHT));
        $iv = "50494D585452454D4550494D58545245";
//        $iv = mcrypt_create_iv(
//                                mcrypt_get_iv_size(
//                                        MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB
//                                ), MCRYPT_RAND
//                        );
        
        $byte_array = unpack('C*', $content);
        $contentTransformed = "";
        foreach ($byte_array as $chr) {
            $contentTransformed .= chr($chr);
        }
        
        return rtrim(
                mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_256, 
                        base64_decode(str_pad($password, 16, " ", STR_PAD_RIGHT)), 
                        base64_decode($contentTransformed), 
                        MCRYPT_MODE_CBC, 
                        $iv
                ), "\0");
    }
}