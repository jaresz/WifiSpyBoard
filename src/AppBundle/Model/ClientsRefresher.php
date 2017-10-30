<?php
namespace AppBundle\Model;

use AppBundle\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;

class ClientsRefresher
{

    protected $conn;

    public function __construct($connection)
    {
        $this->setConn($connection);
    }

    public function insertOrUpdateClientInfo($dhcpFields)
    {
        $conn = $this->getConn();
        $client = [
            'mac' => $dhcpFields['chaddr'],
            'self_name' => $dhcpFields['Host-Name']
        ];
        if (isset($dhcpFields['yiaddr']) && $dhcpFields['yiaddr'])
            $client['ip'] = $dhcpFields['yiaddr'];
        $now = new \DateTime();
        $existing = $conn->fetchAssoc('SELECT * FROM client WHERE mac = ?', array(
            $client['mac']
        ));
        if ($existing) {
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->update('client', $client, [
                'id' => $existing['id']
            ]);
        } else {
            $client['css_class'] = 'client' . rand(0, 28);
            $client['created'] = $now->format('Y-m-d H:i:s');
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->insert('client', $client);
        }
    }

    public function refreshClients()
    {
        $conn = $this->getConn();
        
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
        $resulines = [];
        foreach ($reta as $row) {
            
            
            $lines = explode("\n", $row['msg']);
            $dhcpFields = [];
            if (count($lines))
                foreach ($lines as $line) {
                    if (strstr($line, ' = ')) {
                        $linepart = explode(' = ', $line);
                        
                        if (count($linepart) > 1) {
                            $varName = trim($linepart[0]);
                            $varVal = trim($linepart[1]);
                            
                            $dhcpFields[$varName] = $varVal;
                        }
                    }
                }
            if (count($dhcpFields) > 1 && isset($dhcpFields['chaddr']) && $dhcpFields['chaddr'] && isset($dhcpFields['Host-Name'])) {
                $dhcpFields['Host-Name'] = str_replace('"', '', $dhcpFields['Host-Name']);
                $resulines[$dhcpFields['chaddr']] = $dhcpFields['Host-Name'];                    
                $this->insertOrUpdateClientInfo($dhcpFields);
            }
        }
        
        return $resulines;
    }

    protected function getConn()
    {
        return $this->conn;
    }

    protected function setConn($conn)
    {
        $this->conn = $conn;
        return $this;
    }
}