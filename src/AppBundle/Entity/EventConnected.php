<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EventMacRepository")
 * @ORM\Table(name="eventConnected")
 */
class EventConnected
{

    /**
     * @ORM\OneToOne(targetEntity="Systemevents", inversedBy="eventConnected")
     * @ORM\Id
     * @ORM\JoinColumn(name="system_event_connected_id", referencedColumnName="ID")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $systemEventConnected;
    
    /**
     * @ORM\Column(type="string", length=20, unique=false)
     */
    protected $mac;


    /**
     * Set mac
     *
     * @param string $mac
     *
     * @return EventMac
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
     * Set systemEventConnected
     *
     * @param \AppBundle\Entity\Systemevents $systemEventConnected
     *
     * @return EventConnected
     */
    public function setSystemEventConnected(\AppBundle\Entity\Systemevents $systemEventConnected)
    {
        $this->systemEventConnected = $systemEventConnected;

        return $this;
    }

    /**
     * Get systemEventConnected
     *
     * @return \AppBundle\Entity\Systemevents
     */
    public function getSystemEventConnected()
    {
        return $this->systemEventConnected;
    }
}
