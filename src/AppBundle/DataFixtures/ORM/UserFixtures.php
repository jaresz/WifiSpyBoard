<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $adminPass = $this->container->getParameter('admin_pass');
        
        $unr=0;
        $usrFx = [];
        $usrFx[$unr] = new User();
        $usrFx[$unr]->setUsername("admin");
        $usrFx[$unr]->setName("Administrator");
        $usrFx[$unr]->setEmail("admin@listy.internetowe.pl");
        
        $usrFx[$unr]->setEnabled(true);        
        $usrFx[$unr]->setPlainPassword($adminPass);
        
        
        $manager->persist($usrFx[$unr]);
        $usrFx[$unr]->addRole('ROLE_ADMIN');
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}
