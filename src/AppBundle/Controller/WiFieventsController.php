<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Systemevents;
use AppBundle\Model\ClientTools;
use AppBundle\Model\MacExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Systemevent controller.
 *
 * @Route("events:wifi")
 */
class WiFieventsController extends Controller
{

    /**
     * Lists all systemevent entities.
     *
     * @Route("/", name="wifi_events_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $clientTools = new ClientTools($em);
        
        $q1Builder = $em->createQueryBuilder()
            ->select([
            'Systemevents'
        ])
            ->from('AppBundle\Entity\Systemevents', 'Systemevents')
            ->where("Systemevents.syslogtag=:mm")
            ->setParameter('mm', 'WiFi:')
            ->addOrderBy('Systemevents.id', 'DESC')
            ->setMaxResults(60);
        
        $systemevents = $q1Builder->getQuery()->getResult();
        
        foreach ($systemevents as $systemevent) {
            /**
             * @var Systemevents $systemevent
             */
            $message = $clientTools->replaceMacsByNames($systemevent->getMessage(), true);
            $systemevent->setMessage($message);
        }
        // ->setMaxResults(5)
        return $this->render('systemevents/index.html.twig', array(
            'systemevents' => $systemevents
        ));
    }



    /**
     * Lists all systemevent entities.
     *
     * @Route("/mac/", name="wifi_events_mac_index")
     * @Method("GET")
     */
    public function indexMacAction()
    {
        $em = $this->getDoctrine()->getManager();
            
        $cacExtractor = new MacExtractor($em);
        /* asigning MAC adresses to syslog records based on syslog records messages
         * Exteracted MACs are saved in database.
         */
        $wiconMac = $cacExtractor->extractMacs();
        
        $clientTools = new ClientTools($em);
        
        $fromPoinInTime = new \DateTime();
        $fromPoinInTime->modify('-2 days');
    
        $conn = $this->getDoctrine()->getConnection();
        $conn->fetchAll("SELECT SystemEvents.ID, SystemEvents.ReceivedAt,
                eventConnected.mac as macC,
                eventDisconnected.mac as macD,
                CONCAT(COALESCE(eventConnected.mac,'') , COALESCE(eventDisconnected.mac, '')) as mac
                FROM SystemEvents
                LEFT JOIN eventConnected ON eventConnected.system_event_connected_id = SystemEvents.ID
                LEFT JOIN eventDisconnected ON eventDisconnected.system_event_disconnected_id = SystemEvents.ID
                WHERE (SystemEvents.message LIKE '% connected' OR SystemEvents.message LIKE '% disconnected%')
                AND SystemEvents.ReceivedAt>= ?
                HAVING mac IS NOT NULL AND mac!=''
                ORDER BY mac, macC IS NULL, SystemEvents.ID", [$fromPoinInTime->format('Y-m-d H:i:s')]
                );
        
        $q1Builder = $em->createQueryBuilder()
        ->select([
            'Systemevents',
            'EventConnected',
            'EventDisconnected'
        ])
        ->from('AppBundle\Entity\Systemevents', 'Systemevents')
        ->leftJoin('Systemevents.eventConnected', 'EventConnected')
        ->leftJoin('Systemevents.eventDisconnected', 'EventDisconnected')
        ->where("Systemevents.syslogtag=:syslogtag")
        ->setParameter('syslogtag', 'WiFi:')
        ->andWhere("EventConnected.mac IS NOT NULL")
        //->andWhere("Systemevents.id IN (32508, 32513)")
        ->andWhere("(Systemevents.message LIKE '% connected' OR Systemevents.message LIKE '% disconnected%')")
        ->andWhere("Systemevents.devicereportedtime > :fromPoinInTime")
        ->setParameter('fromPoinInTime', $fromPoinInTime)
        ->addOrderBy('Systemevents.id', 'DESC')
        ;
    
        $wifiConnections = $q1Builder->getQuery()->getResult();
    
        foreach ($wifiConnections as $wifiConnection) {
            /**
             * @var Systemevents $systemevent
             */
            $message = $clientTools->replaceMacsByNames($wifiConnection->getMessage(), true);
            $wifiConnection->setMessage($message);
        }
        // ->setMaxResults(5)
        return $this->render('systemevents/mac_index.html.twig', array(
            'systemevents' => $wifiConnections
        ));
    }
    
    
    /**
     * Finds and displays a systemevent entity.
     *
     * @Route("/{id}", name="system_events_show")
     * @Method("GET")
     */
    public function showAction(Systemevents $systemevent)
    {
        $em = $this->getDoctrine()->getManager();
        $clientTools = new ClientTools($em);
        $message = $clientTools->replaceMacsByNames($systemevent->getMessage(), true);
        $systemevent->setMessage($message);
        
        return $this->render('systemevents/show.html.twig', array(
            'systemevent' => $systemevent
        ));
    }
}
