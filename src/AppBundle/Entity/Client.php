<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ClientRepository")
 * @ORM\Table(name="client")
 * @ORM\HasLifecycleCallbacks
 */
class Client
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $mac;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $ip;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $selfName;
    

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $cssClass='';

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $givenName;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updated;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function __toString()
    {
        return $this->getName();
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
     * Set mac
     *
     * @param string $mac            
     *
     * @return Client
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
        
        return $this;
    }

    /**
     * Get mac
     *
     * @return string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Set ip
     *
     * @param string $ip            
     *
     * @return Client
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        
        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set selfName
     *
     * @param string $selfName            
     *
     * @return Client
     */
    public function setSelfName($selfName)
    {
        $this->selfName = $selfName;
        
        return $this;
    }

    /**
     * Get selfName
     *
     * @return string
     */
    public function getSelfName()
    {
        return $this->selfName;
    }

    /**
     * Set givenName
     *
     * @param string $givenName            
     *
     * @return Client
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
        
        return $this;
    }

    /**
     * Get givenName
     *
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Get name - given or self name
     *
     * @return string
     */
    public function getName()
    {
        if (isset($this->givenName) && $this->givenName)
            return $this->givenName;
        else
            return $this->selfName;
    }

    /**
     * Set created
     *
     * @param \DateTime $created            
     *
     * @return Client
     */
    public function setCreated($created)
    {
        $this->created = $created;
        
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Client
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set cssClass
     *
     * @param string $cssClass
     *
     * @return Client
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;

        return $this;
    }

    /**
     * Get cssClass
     *
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }
}
