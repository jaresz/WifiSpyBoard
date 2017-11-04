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
     * @Route("/events/", name="wifi_events_index")
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
     * @Route("/sessions/", name="wifi_sessions")
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
        $nadaysBack = $this->container
        ->getParameter('days_back');
        if (!$nadaysBack || $nadaysBack<1) $nadaysBack=3;
        $fromPoinInTime->modify('-'.$nadaysBack.' days');
    
        $conn = $this->getDoctrine()->getConnection();
        
        $lastConns = $conn->fetchAll("SELECT SystemEvents.FromHost, eventConnected.mac as mac,
                MAX(SystemEvents.ReceivedAt) AS lastTime
                FROM SystemEvents
                LEFT JOIN eventConnected ON eventConnected.system_event_connected_id = SystemEvents.ID
                WHERE (SystemEvents.message LIKE '% connected' )
                AND SystemEvents.syslogtag = 'WiFi:'
                AND SystemEvents.ReceivedAt >= ?
                GROUP BY SystemEvents.FromHost, eventConnected.mac
                HAVING mac IS NOT NULL AND mac!=''
                ORDER BY lastTime DESC, mac, SystemEvents.FromHost", [$fromPoinInTime->format('Y-m-d H:i:s')]
            );
       
        $sessionsInfo = [];
        foreach($lastConns as $lastConn) {            
           //dump($lastConn);
           $sessionInfo = [             
             'clientInfo' => $lastConn['mac'],
             'FromHost' => $lastConn['FromHost'],
             'mac' => $lastConn['mac'],
             'connectedOn' => $lastConn['lastTime'],
             'disconnectedOn' => null
           ];
           
           $lastDisconn = $conn->fetchAssoc("SELECT SystemEvents.ID, SystemEvents.ReceivedAt,
                eventDisconnected.mac as mac
                FROM SystemEvents
                LEFT JOIN eventDisconnected ON eventDisconnected.system_event_disconnected_id = SystemEvents.ID
                WHERE (SystemEvents.message LIKE '% disconnected%')
                AND SystemEvents.syslogtag = 'WiFi:'
                AND SystemEvents.ReceivedAt>= ?
                AND eventDisconnected.mac = ?
                AND SystemEvents.FromHost = ?
                ", [$lastConn['lastTime'], $lastConn['mac'], $lastConn['FromHost']]);
           //dump($lastDisconn);
           if ($lastDisconn) 
               $sessionInfo['disconnectedOn'] =  $lastDisconn['ReceivedAt'];
           
           $sessionInfo['clientInfo'] = $clientTools->replaceMacsByNames($lastConn['mac'], true);
               
           $sessionsInfo[] = $sessionInfo;
        }
        
        
        
        return $this->render('systemevents/sessions.html.twig', array(
            'sessionsInfo' => $sessionsInfo
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
