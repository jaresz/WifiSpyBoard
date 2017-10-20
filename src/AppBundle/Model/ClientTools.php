<?php
namespace AppBundle\Model;

use AppBundle\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;

class ClientTools extends AbstractClassWithEntityManager
{
    protected $clients;
    /**
     * 
     * @param string $macAddr
     * @return Client
     */

    public function findUserByName($macAddr)
    {
        $em = $this->entityManager;
        $cli = $em->getRepository('AppBundle:Client')->findOneByMac($macAddr);
        return $cli;
    }

    public function __construct($em) {
        parent::__construct($em);
        $all = $em->getRepository('AppBundle:Client')->findAll();
        foreach ($all as $one) {
            /**
             * @var Client $one
             */
            $this->clients[$one->getMac()] = $one;           
        }
    }
    
    public function replaceMacsByNames($text, $useHtml=true)
    {
        if ($useHtml) {
            $htmlNamePre = '<span class="clientName">';
            $htmlNameSuf = '</span> ';
            $htmlMacPre = '<span class="clientMac">';
            $htmlMacSuf = '</span>';
        } else {
            $htmlNamePre = '';
            $htmlNameSuf = ' ';
            $htmlMacPre = '(';
            $htmlMacSuf = ')';
        }
        foreach($this->clients as $client) {
            /** @var Client $client            
             */
            $count = 0;
            $replcd = str_replace($client->getMac(), $htmlNamePre.$client->getName().$htmlNameSuf.$htmlMacPre.$client->getMac().$htmlMacSuf, $text, $count);
            if ($count) {
                $text = $replcd;
                break;
            }
        }
        return $text;
    }
}