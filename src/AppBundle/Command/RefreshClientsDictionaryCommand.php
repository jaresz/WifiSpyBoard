<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use AppBundle\Model\ClientsRefresher;

class RefreshClientsDictionaryCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this->
        // the name of the command (the part after "bin/console")
        setName('app:refresh-clients-dictionary')
            ->setDescription('Refreshes clients MAC - name dictionary')
            ->setHelp('Just run without parameters...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('magenta', 'black', array());
        $output->getFormatter()->setStyle('var', $style);
        
        $style = new OutputFormatterStyle('yellow', 'blue', array('bold'));
        $output->getFormatter()->setStyle('value', $style);
        
       
        
        $output->writeln('RefreshClientsDictionaryCommand');
        
        $conn = $this->getContainer()->get('doctrine.dbal.default_connection');
        
        $clientsRefresher = new ClientsRefresher($conn);
        
        $resulines = $clientsRefresher->refreshClients();
       
        foreach ($resulines as $clie) {
           $output->writeln($clie['chaddr']."\t".$clie['Host-Name']);            
        }
        
    }
}

