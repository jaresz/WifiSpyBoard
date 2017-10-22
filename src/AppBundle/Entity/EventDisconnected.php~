<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EventMacRepository")
 * @ORM\Table(name="eventDisconnected")
 */
class EventDisconnected
{

    /**
     * @ORM\OneToOne(targetEntity="Systemevents", inversedBy="eventDisconnected")
     * @ORM\Id
     * @ORM\JoinColumn(name="system_event_disconnected_id", referencedColumnName="ID")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $systemEventDisconnected;
    
    /**
     * @ORM\Column(type="string", length=20, unique=false)
     */
    protected $mac;


    /**
     * Set mac
     *
     * @param string $mac
     *
     * @return EventDisconnected
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
     * Set systemEventDisconnected
     *
     * @param \AppBundle\Entity\Systemevents $systemEventDisconnected
     *
     * @return EventDisconnected
     */
    public function setSystemEventDisconnected(\AppBundle\Entity\Systemevents $systemEventDisconnected)
    {
        $this->systemEventDisconnected = $systemEventDisconnected;

        return $this;
    }

    /**
     * Get systemEventDisconnected
     *
     * @return \AppBundle\Entity\Systemevents
     */
    public function getSystemEventDisconnected()
    {
        return $this->systemEventDisconnected;
    }
}
