<?php

namespace Pimx\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Pimx\ModelBundle\Utilities\RtfToHtml;

/** @ORM\HasLifecycleCallbacks */
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
        return $this->content;
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
    
    /** @ORM\PrePersist */
    public function doStuffOnPrePersist()
    {
        $contentToSet = $this->content;        
        //encrypt, if it's necessary
        if($this->isEncrypted) {
            $contentToSet = $this->encrypt($this->content, $this->cryptPassword);
        }        
        $this->content = $contentToSet;
        
        $this->inputdate = $this->lastmodifdate = new \DateTime();
    }
    /** @ORM\PreUpdate */
    public function doStuffOnPreUpdate()
    {
        $contentToSet = $this->content;        
        //encrypt, if it's necessary
        if($this->isEncrypted) {
            $contentToSet = $this->encrypt($this->content, $this->cryptPassword);
        }        
        $this->content = $contentToSet;
        
        $this->lastmodifdate = new \DateTime();
    }
    /** @ORM\PostLoad */
    public function doStuffOnPostLoad()
    {
        $contentToReturn = $this->content;
        //decrypt, if it's necessary
        if($this->isEncrypted) {
            $this->cryptPassword = "123";
            $contentToReturn = $this->decrypt($this->content, $this->cryptPassword);
        }
        //check if it is RTF
//        if( strpos($contentToReturn, '{\rtf') === 0 ){
//            $rtfConverter = new RtfToHtml();
//            $contentToReturn = $rtfConverter->convert($contentToReturn);
//        }
        $this->content = $contentToReturn;
        
    }
    
    private function decrypt_OLD($content, $password) {
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
    
    private function encrypt($content, $password) {
//        $key = pack('H*', "bcb04b7e204a0cd8b54763051cef08bc55abe129fdebae5e1d417e2ffb2a00a3");
        $key = pack('H*', md5($password) . md5($password));
        $key_size =  strlen($key);
        
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        
        echo $key . "\n<br>";
        echo $iv . "\n<br>";
        $encriptedData = mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256, 
                $key, 
                $content, 
                MCRYPT_MODE_CBC, 
                $iv);
        
        # prepend the IV for it to be available for decryption
        $encriptedData = $iv . $encriptedData;
        # encode the resulting cipher text so it can be represented by a string
        return base64_encode($encriptedData);
    }
    
    private function decrypt($content, $password) {
        $ciphertext_dec = base64_decode($content);
        $key = pack('H*', md5($password) . md5($password));

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        # may remove 00h valued characters from end of plain text
        $plaintext_dec = mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, 
                $key,
                $ciphertext_dec, 
                MCRYPT_MODE_CBC, 
                $iv_dec);

        return trim($plaintext_dec);
    }
}