<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Systemevents
 *
 * @ORM\Table(name="SystemEvents")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SystemeventsRepository")
 */
class Systemevents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CustomerID", type="bigint", nullable=true)
     */
    private $customerid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ReceivedAt", type="datetime", nullable=true)
     */
    private $receivedat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DeviceReportedTime", type="datetime", nullable=true)
     */
    private $devicereportedtime;

    /**
     * @var integer
     *
     * @ORM\Column(name="Facility", type="smallint", nullable=true)
     */
    private $facility;

    /**
     * @var integer
     *
     * @ORM\Column(name="Priority", type="smallint", nullable=true)
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="FromHost", type="string", length=60, nullable=true)
     */
    private $fromhost;

    /**
     * @var string
     *
     * @ORM\Column(name="Message", type="text", length=65535, nullable=true)
     */
    private $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="NTSeverity", type="integer", nullable=true)
     */
    private $ntseverity;

    /**
     * @var integer
     *
     * @ORM\Column(name="Importance", type="integer", nullable=true)
     */
    private $importance;

    /**
     * @var string
     *
     * @ORM\Column(name="EventSource", type="string", length=60, nullable=true)
     */
    private $eventsource;

    /**
     * @var string
     *
     * @ORM\Column(name="EventUser", type="string", length=60, nullable=true)
     */
    private $eventuser;

    /**
     * @var integer
     *
     * @ORM\Column(name="EventCategory", type="integer", nullable=true)
     */
    private $eventcategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="EventID", type="integer", nullable=true)
     */
    private $eventid;

    /**
     * @var string
     *
     * @ORM\Column(name="EventBinaryData", type="text", length=65535, nullable=true)
     */
    private $eventbinarydata;

    /**
     * @var integer
     *
     * @ORM\Column(name="MaxAvailable", type="integer", nullable=true)
     */
    private $maxavailable;

    /**
     * @var integer
     *
     * @ORM\Column(name="CurrUsage", type="integer", nullable=true)
     */
    private $currusage;

    /**
     * @var integer
     *
     * @ORM\Column(name="MinUsage", type="integer", nullable=true)
     */
    private $minusage;

    /**
     * @var integer
     *
     * @ORM\Column(name="MaxUsage", type="integer", nullable=true)
     */
    private $maxusage;

    /**
     * @var integer
     *
     * @ORM\Column(name="InfoUnitID", type="integer", nullable=true)
     */
    private $infounitid;

    /**
     * @var string
     *
     * @ORM\Column(name="SysLogTag", type="string", length=60, nullable=true)
     */
    private $syslogtag;

    /**
     * @var string
     *
     * @ORM\Column(name="EventLogType", type="string", length=60, nullable=true)
     */
    private $eventlogtype;

    /**
     * @var string
     *
     * @ORM\Column(name="GenericFileName", type="string", length=60, nullable=true)
     */
    private $genericfilename;

    /**
     * @var integer
     *
     * @ORM\Column(name="SystemID", type="integer", nullable=true)
     */
    private $systemid;
    

    /**
     * @ORM\OneToOne(targetEntity="EventConnected", mappedBy="systemEventConnected")
     */
    private $eventConnected;


    /**
     * @ORM\OneToOne(targetEntity="EventDisconnected", mappedBy="systemEventDisconnected")
     */
    private $eventDisconnected;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set customerid
     *
     * @param integer $customerid
     *
     * @return Systemevents
     */
    public function setCustomerid($customerid)
    {
        $this->customerid = $customerid;

        return $this;
    }

    /**
     * Get customerid
     *
     * @return integer
     */
    public function getCustomerid()
    {
        return $this->customerid;
    }

    /**
     * Set receivedat
     *
     * @param \DateTime $receivedat
     *
     * @return Systemevents
     */
    public function setReceivedat($receivedat)
    {
        $this->receivedat = $receivedat;

        return $this;
    }

    /**
     * Get receivedat
     *
     * @return \DateTime
     */
    public function getReceivedat()
    {
        return $this->receivedat;
    }

    /**
     * Set devicereportedtime
     *
     * @param \DateTime $devicereportedtime
     *
     * @return Systemevents
     */
    public function setDevicereportedtime($devicereportedtime)
    {
        $this->devicereportedtime = $devicereportedtime;

        return $this;
    }

    /**
     * Get devicereportedtime
     *
     * @return \DateTime
     */
    public function getDevicereportedtime()
    {
        return $this->devicereportedtime;
    }

    /**
     * Set facility
     *
     * @param integer $facility
     *
     * @return Systemevents
     */
    public function setFacility($facility)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * Get facility
     *
     * @return integer
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Systemevents
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set fromhost
     *
     * @param string $fromhost
     *
     * @return Systemevents
     */
    public function setFromhost($fromhost)
    {
        $this->fromhost = $fromhost;

        return $this;
    }

    /**
     * Get fromhost
     *
     * @return string
     */
    public function getFromhost()
    {
        return $this->fromhost;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Systemevents
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set ntseverity
     *
     * @param integer $ntseverity
     *
     * @return Systemevents
     */
    public function setNtseverity($ntseverity)
    {
        $this->ntseverity = $ntseverity;

        return $this;
    }

    /**
     * Get ntseverity
     *
     * @return integer
     */
    public function getNtseverity()
    {
        return $this->ntseverity;
    }

    /**
     * Set importance
     *
     * @param integer $importance
     *
     * @return Systemevents
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;

        return $this;
    }

    /**
     * Get importance
     *
     * @return integer
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * Set eventsource
     *
     * @param string $eventsource
     *
     * @return Systemevents
     */
    public function setEventsource($eventsource)
    {
        $this->eventsource = $eventsource;

        return $this;
    }

    /**
     * Get eventsource
     *
     * @return string
     */
    public function getEventsource()
    {
        return $this->eventsource;
    }

    /**
     * Set eventuser
     *
     * @param string $eventuser
     *
     * @return Systemevents
     */
    public function setEventuser($eventuser)
    {
        $this->eventuser = $eventuser;

        return $this;
    }

    /**
     * Get eventuser
     *
     * @return string
     */
    public function getEventuser()
    {
        return $this->eventuser;
    }

    /**
     * Set eventcategory
     *
     * @param integer $eventcategory
     *
     * @return Systemevents
     */
    public function setEventcategory($eventcategory)
    {
        $this->eventcategory = $eventcategory;

        return $this;
    }

    /**
     * Get eventcategory
     *
     * @return integer
     */
    public function getEventcategory()
    {
        return $this->eventcategory;
    }

    /**
     * Set eventid
     *
     * @param integer $eventid
     *
     * @return Systemevents
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;

        return $this;
    }

    /**
     * Get eventid
     *
     * @return integer
     */
    public function getEventid()
    {
        return $this->eventid;
    }

    /**
     * Set eventbinarydata
     *
     * @param string $eventbinarydata
     *
     * @return Systemevents
     */
    public function setEventbinarydata($eventbinarydata)
    {
        $this->eventbinarydata = $eventbinarydata;

        return $this;
    }

    /**
     * Get eventbinarydata
     *
     * @return string
     */
    public function getEventbinarydata()
    {
        return $this->eventbinarydata;
    }

    /**
     * Set maxavailable
     *
     * @param integer $maxavailable
     *
     * @return Systemevents
     */
    public function setMaxavailable($maxavailable)
    {
        $this->maxavailable = $maxavailable;

        return $this;
    }

    /**
     * Get maxavailable
     *
     * @return integer
     */
    public function getMaxavailable()
    {
        return $this->maxavailable;
    }

    /**
     * Set currusage
     *
     * @param integer $currusage
     *
     * @return Systemevents
     */
    public function setCurrusage($currusage)
    {
        $this->currusage = $currusage;

        return $this;
    }

    /**
     * Get currusage
     *
     * @return integer
     */
    public function getCurrusage()
    {
        return $this->currusage;
    }

    /**
     * Set minusage
     *
     * @param integer $minusage
     *
     * @return Systemevents
     */
    public function setMinusage($minusage)
    {
        $this->minusage = $minusage;

        return $this;
    }

    /**
     * Get minusage
     *
     * @return integer
     */
    public function getMinusage()
    {
        return $this->minusage;
    }

    /**
     * Set maxusage
     *
     * @param integer $maxusage
     *
     * @return Systemevents
     */
    public function setMaxusage($maxusage)
    {
        $this->maxusage = $maxusage;

        return $this;
    }

    /**
     * Get maxusage
     *
     * @return integer
     */
    public function getMaxusage()
    {
        return $this->maxusage;
    }

    /**
     * Set infounitid
     *
     * @param integer $infounitid
     *
     * @return Systemevents
     */
    public function setInfounitid($infounitid)
    {
        $this->infounitid = $infounitid;

        return $this;
    }

    /**
     * Get infounitid
     *
     * @return integer
     */
    public function getInfounitid()
    {
        return $this->infounitid;
    }

    /**
     * Set syslogtag
     *
     * @param string $syslogtag
     *
     * @return Systemevents
     */
    public function setSyslogtag($syslogtag)
    {
        $this->syslogtag = $syslogtag;

        return $this;
    }

    /**
     * Get syslogtag
     *
     * @return string
     */
    public function getSyslogtag()
    {
        return $this->syslogtag;
    }

    /**
     * Set eventlogtype
     *
     * @param string $eventlogtype
     *
     * @return Systemevents
     */
    public function setEventlogtype($eventlogtype)
    {
        $this->eventlogtype = $eventlogtype;

        return $this;
    }

    /**
     * Get eventlogtype
     *
     * @return string
     */
    public function getEventlogtype()
    {
        return $this->eventlogtype;
    }

    /**
     * Set genericfilename
     *
     * @param string $genericfilename
     *
     * @return Systemevents
     */
    public function setGenericfilename($genericfilename)
    {
        $this->genericfilename = $genericfilename;

        return $this;
    }

    /**
     * Get genericfilename
     *
     * @return string
     */
    public function getGenericfilename()
    {
        return $this->genericfilename;
    }

    /**
     * Set systemid
     *
     * @param integer $systemid
     *
     * @return Systemevents
     */
    public function setSystemid($systemid)
    {
        $this->systemid = $systemid;

        return $this;
    }

    /**
     * Get systemid
     *
     * @return integer
     */
    public function getSystemid()
    {
        return $this->systemid;
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
     * Set eventConnected
     *
     * @param \AppBundle\Entity\EventConnected $eventConnected
     *
     * @return Systemevents
     */
    public function setEventConnected(\AppBundle\Entity\EventConnected $eventConnected = null)
    {
        $this->eventConnected = $eventConnected;

        return $this;
    }

    /**
     * Get eventConnected
     *
     * @return \AppBundle\Entity\EventConnected
     */
    public function getEventConnected()
    {
        return $this->eventConnected;
    }

    /**
     * Set eventDisconnected
     *
     * @param \AppBundle\Entity\EventDisconnected $eventDisconnected
     *
     * @return Systemevents
     */
    public function setEventDisconnected(\AppBundle\Entity\EventDisconnected $eventDisconnected = null)
    {
        $this->eventDisconnected = $eventDisconnected;

        return $this;
    }

    /**
     * Get eventDisconnected
     *
     * @return \AppBundle\Entity\EventDisconnected
     */
    public function getEventDisconnected()
    {
        return $this->eventDisconnected;
    }
}
