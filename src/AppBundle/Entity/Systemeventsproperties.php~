<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Systemeventsproperties
 *
 * @ORM\Table(name="SystemEventsProperties")
 * @ORM\Entity
 */
class Systemeventsproperties
{
    /**
     * @var integer
     *
     * @ORM\Column(name="SystemEventID", type="integer", nullable=true)
     */
    private $systemeventid;

    /**
     * @var string
     *
     * @ORM\Column(name="ParamName", type="string", length=255, nullable=true)
     */
    private $paramname;

    /**
     * @var string
     *
     * @ORM\Column(name="ParamValue", type="text", length=65535, nullable=true)
     */
    private $paramvalue;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set systemeventid
     *
     * @param integer $systemeventid
     *
     * @return Systemeventsproperties
     */
    public function setSystemeventid($systemeventid)
    {
        $this->systemeventid = $systemeventid;

        return $this;
    }

    /**
     * Get systemeventid
     *
     * @return integer
     */
    public function getSystemeventid()
    {
        return $this->systemeventid;
    }

    /**
     * Set paramname
     *
     * @param string $paramname
     *
     * @return Systemeventsproperties
     */
    public function setParamname($paramname)
    {
        $this->paramname = $paramname;

        return $this;
    }

    /**
     * Get paramname
     *
     * @return string
     */
    public function getParamname()
    {
        return $this->paramname;
    }

    /**
     * Set paramvalue
     *
     * @param string $paramvalue
     *
     * @return Systemeventsproperties
     */
    public function setParamvalue($paramvalue)
    {
        $this->paramvalue = $paramvalue;

        return $this;
    }

    /**
     * Get paramvalue
     *
     * @return string
     */
    public function getParamvalue()
    {
        return $this->paramvalue;
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
}
