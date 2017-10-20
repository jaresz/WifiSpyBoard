<?php
namespace AppBundle\Model;

abstract class AbstractClassWithEntityManager
{    
    protected $entityManager;
    
    
    
    public function setEntityManager($pem)
    {
        $this->entityManager = $pem;
    }
    
    public function  getEntityManager()
    {
        return $this->entityManager;
    }
    
    public function __construct($em) {
        $this->setEntityManager( $em );
       
    }
    
}