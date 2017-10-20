<?php
// src/AppBundle/Entity/User.php
 
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use AppBundle\Entity\Department;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
 
/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(
 *     fields={"email"},
 *     groups={"Strict"},
 *     message="Email is already used."
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     groups={"Strict"},
 *     message="Name is already used."
 * )
 * 
 * --zssert\GroupSequence({"User", "Strict"})
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Assert\NotBlank(groups={"registration", "admin_edit"})
     * @Assert\Length(min=5, groups={"registration", "admin_edit"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=32)
     */  
    protected  $rapas;
    
    /**
     * @Assert\NotBlank(groups={"registration", "admin_edit"})
     * @Assert\Email(groups={"registration", "admin_edit"})
     */
    protected $email;
    
    
    /**
     * @Assert\NotBlank(groups={"registration", "change_pass"})
     * @Assert\Length(min=6, groups={"registration", "change_pass"})
     */
    protected $plainPassword;
    
    /**
     * @Assert\IsTrue(message="Hasło nie może być takie samo, jak login.", groups={"Strict", "registration", "admin_edit"})
     */
    public function isPasswordLegal()
    {
        if (!$this->plainPassword) return true;
        return ($this->username !== $this->plainPassword);
    }
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;
    
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isAdmin;
    
   
    
    public function __construct()
    {
        parent::__construct();
       
        $this->isAdmin=false;
        // additional id
        $this->setRapas(substr(md5(rand(199,9999)), 0, 10));
        
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set isAdmin
     *
     * @param boolean $isAdmin
     *
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    
    public function __toString()
    {
            return (string) $this->getName(); 
    }


    /**
     * Set rapas
     *
     * @param string $rapas
     *
     * @return User
     */
    public function setRapas($rapas)
    {
        $this->rapas = $rapas;

        return $this;
    }

    /**
     * Get rapas
     *
     * @return string
     */
    public function getRapas()
    {
        return $this->rapas;
    }
}
