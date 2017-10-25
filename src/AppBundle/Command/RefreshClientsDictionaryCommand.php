<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class RefreshClientsDictionaryCommand extends ContainerAwareCommand
{
    protected function insertOrUpdateClientInfo($dhcpFields)
    {
        $conn = $this->getContainer()->get('doctrine.dbal.default_connection');
        $client = ['mac'=>$dhcpFields['chaddr'], 'self_name'=>$dhcpFields['Host-Name']];
        if (isset($dhcpFields['yiaddr']) && $dhcpFields['yiaddr']) $client['ip'] = $dhcpFields['yiaddr'];        
        $now = new \DateTime();
        $existing =  $conn->fetchAssoc('SELECT * FROM client WHERE mac = ?', array($client['mac']));
        if ($existing) {
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->update('client', $client, ['id'=>$existing['id']]);
        } else {
            $client['css_class'] = 'client'.rand(0,11); 
            $client['created'] = $now->format('Y-m-d H:i:s');
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->insert('client', $client);
        }
    }

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
        $reta = $conn->fetchAll('SELECT deviceReportedTime, fromHost, GROUP_CONCAT(TRIM(Message) SEPARATOR "\n") as msg
                                FROM SystemEvents
                                WHERE 
                                	SysLogTag = "DHCP:"
                                AND (
                                       Message LIKE "%Client-Id =%" OR Message LIKE "%Class-Id =%"  
                                    OR Message LIKE "%Host-Name =%"  OR Message LIKE "%chaddr =%"
                                    OR Message LIKE "%Server-Id =%" 
                                    OR Message LIKE "%yiaddr =%"                                     
                                    )
                                GROUP BY DeviceReportedTime, fromHost
                                
                                ');
        foreach ($reta as $row) {
            $output->write($row['deviceReportedTime']);            
            $output->write("\t");
            /*
            $output->write($row['fromHost']);
            $output->write("\t");
            $output->writeln($row['msg']);
            */
            $lines = explode("\n", $row['msg']);
            $dhcpFields = [];
            if (count($lines))
            foreach ($lines as $line) {
                //$output->writeln("-<value>".$line."</value>");
                if (strstr($line, ' = ')) {
                    $linepart = explode(' = ', $line);
                    //dump($linepart);
                    if (count($linepart)>1) {
                        $varName = trim($linepart[0]);
                        $varVal = trim($linepart[1]);
                        //$output->write("\t<var>".$varName."</var>: ");
                        //$output->write("<value>".$varVal."</value>\n");
                        $dhcpFields[$varName] = $varVal;
                        
                    }
                }
            }
            if (count($dhcpFields)>1 && isset($dhcpFields['chaddr']) && $dhcpFields['chaddr'] && isset($dhcpFields['Host-Name'])) {
                $dhcpFields['Host-Name'] = str_replace('"', '', $dhcpFields['Host-Name']);
                $output->write($dhcpFields['chaddr']);
                $output->write("\t");
                $output->write($dhcpFields['Host-Name']);
                $this->insertOrUpdateClientInfo($dhcpFields);
            }
            $output->writeln(" ");
        }
    }
}

