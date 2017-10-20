<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Systemevents;
use AppBundle\Model\ClientTools;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Systemevent controller.
 *
 * @Route("events:system")
 */
class SystemeventsController extends Controller
{
    /**
     * Lists all systemevent entities.
     *
     * @Route("/", name="system_events_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
           
        $clientTools = new ClientTools($em);
        
        //$systemevents = $em->getRepository('AppBundle:Systemevents')->findAll();
        $q1Builder = $em->createQueryBuilder()
        ->select([
            'Systemevents'
        ])
        ->from('AppBundle\Entity\Systemevents', 'Systemevents')
        ->where("Systemevents.fromhost!=:mm")
        ->setParameter('mm', 'mediomalina')
        ->addOrderBy('Systemevents.id', 'DESC')
        ->setMaxResults(90);
        
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
            'systemevents' => $systemevents,
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

        return $this->render('systemevents/show.html.twig', array(
            'systemevent' => $systemevent,
        ));
    }
}
