<?php
namespace Pimx\ModelBundle\Entity\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class PimxUser implements UserInterface
{
    protected $username;
    protected $password;
    protected $roles;
        
    protected $dbname;
    protected $dbuser;
    protected $dbpass;
     
    public function __construct($username, $password, array $roles, $dbname = NULL, $dbuser = NULL, $dbpass = NULL)
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        
        $this->dbname = $dbname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
    }
     
    public function getRoles()
    {
        return $this->roles;
    }
 
    public function getPassword()
    {
        return $this->password;
    }
 
    public function getSalt()
    {
        return "";
    }
 
    public function getUsername()
    {
        return $this->username;
    }   
 
    public function getDbname(){
        return $this->dbname;
    }
    public function getDbuser(){
        return $this->dbuser;
    }
    public function getDbpass(){
        return $this->dbpass;
    }
    
    public function eraseCredentials()
    {
    }
     
    public function equals(UserInterface $user)
    {
        if (!$user instanceof PimxUser) {
            return false;
        }
 
        if ($this->password !== $user->getPassword()) {
            return false;
        }
 
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }
 
        if ($this->username !== $user->getUsername()) {
            return false;
        }
         
        return true;
    }
    
    
}