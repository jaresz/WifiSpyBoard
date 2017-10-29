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
        $client = ['mac'=>$dhcpFields['chaddr'], 'self_name'=>$dhcpFields['Host-Name']];
        if (isset($dhcpFields['yiaddr']) && $dhcpFields['yiaddr']) $client['ip'] = $dhcpFields['yiaddr'];
        $now = new \DateTime();
        $existing =  $conn->fetchAssoc('SELECT * FROM client WHERE mac = ?', array($client['mac']));
        if ($existing) {
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->update('client', $client, ['id'=>$existing['id']]);
        } else {
            $client['css_class'] = 'client'.rand(0,28);
            $client['created'] = $now->format('Y-m-d H:i:s');
            $client['updated'] = $now->format('Y-m-d H:i:s');
            $conn->insert('client', $client);
        }
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