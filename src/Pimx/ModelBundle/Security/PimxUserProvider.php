<?php
namespace Pimx\ModelBundle\Security;
 
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
 
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
 
use Symfony\Component\Yaml\Yaml;

use Pimx\ModelBundle\Entity\Security\PimxUser;
 
class PimxUserProvider implements UserProviderInterface
{
    protected $users;
     
    public function __construct($yml_path)
    {
        $userDefinitions = Yaml::parse($yml_path);
         
        $this->users = array();
         
        foreach ($userDefinitions as $username => $attributes) {
            $password = isset($attributes['password']) ? $attributes['password'] : null;
            $roles = isset($attributes['roles']) ? $attributes['roles'] : array();
            $dbname = isset($attributes['dbname']) ? $attributes['dbname'] : null;
            $dbuser = isset($attributes['dbuser']) ? $attributes['dbuser'] : null;
            $dbpass = isset($attributes['dbpass']) ? $attributes['dbpass'] : null;
 
            $this->users[$username] = new PimxUser($username, $password, $roles
                    , $dbname, $dbuser, $dbpass);
        }
    }
     
    public function loadUserByUsername($username)
    {
        if (!isset($this->users[$username])) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
         
        $user = $this->users[$username];
         
        return $user;
//        return new PimxUser($user->getUsername(), $user->getPassword(), $user->getRoles()
//                , $user->getDbname(), $user->getDbuser(), $user->getDbpass());
    }
 
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof PimxUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
 
        return $this->loadUserByUsername($user->getUsername());        
    }
 
    public function supportsClass($class)
    {
        return $class === 'Pimx\ModelBundle\Entity\Security\PimxUser';
    }
}
