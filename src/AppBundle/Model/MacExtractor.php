<?php
namespace AppBundle\Model;

use AppBundle\Entity\Client;
use AppBundle\Entity\Systemevents;
use AppBundle\Entity\EventConnected;
use AppBundle\Entity\EventDisconnected;
use AppBundle\Model\ClientTools;
use Doctrine\Common\Persistence\ObjectManager;

class MacExtractor extends AbstractClassWithEntityManager
{


    public function extractMacs()
    {       
        $em = $this->entityManager;       
        $clientTools = new ClientTools($em);

        $q1Builder = $em->createQueryBuilder()
        ->select([
            'Systemevents',
            'EventConnected'
        ])
        ->from('AppBundle\Entity\Systemevents', 'Systemevents')
        ->leftJoin('Systemevents.eventConnected', 'EventConnected')
        ->where("Systemevents.syslogtag=:syslogtag")
        ->setParameter('syslogtag', 'WiFi:')
        ->andWhere("EventConnected.mac IS NULL")
        ->andWhere("Systemevents.message LIKE '% connected'")
        ->addOrderBy('Systemevents.id', 'ASC')
        ->setMaxResults(500);
        // OR Systemevents.message LIKE '%disconnected%'
        //dump($q1Builder->getQuery());
        
        $wifiEvents = $q1Builder->getQuery()->getResult();
        
        foreach ($wifiEvents as $wifiEvent) {
            /**
             * @var Systemevents $wifiEvent
             */
           $mac = $clientTools->getMac( $wifiEvent->getMessage() );

           $eventCon = new EventConnected();
           $eventCon->setSystemEventConnected($wifiEvent);
           $eventCon->setMac($mac);
           $em->persist($eventCon);
           
        } 
        
        $q1Builder = $em->createQueryBuilder()
        ->select([
            'Systemevents',
            'EventDisconnected'
        ])
        ->from('AppBundle\Entity\Systemevents', 'Systemevents')
        ->leftJoin('Systemevents.eventDisconnected', 'EventDisconnected')
        ->where("Systemevents.syslogtag=:syslogtag")
        ->setParameter('syslogtag', 'WiFi:')
        ->andWhere("EventDisconnected.mac IS NULL")
        ->andWhere("Systemevents.message LIKE '% disconnected%'")
        ->addOrderBy('Systemevents.id', 'ASC')
        ->setMaxResults(500);
        // OR Systemevents.message LIKE '%disconnected%'
        //dump($q1Builder->getQuery());
        
        $wifiEvents = $q1Builder->getQuery()->getResult();
        
        foreach ($wifiEvents as $wifiEvent) {
            /**
             * @var Systemevents $wifiEvent
             */
            $mac = $clientTools->getMac( $wifiEvent->getMessage() );
        
            $eventCon = new EventDisconnected();
            $eventCon->setSystemEventDisconnected($wifiEvent);
            $eventCon->setMac($mac);
            $em->persist($eventCon);
             
        }
        
        $em->flush();
        return $wifiEvents;
    }


}