<?php
 
namespace Classes\Models\SharePoint\Rdp;
use Classes\Models\SharePoint\Rdp\Rdp;
use Classes\Utils\Sql;

class RdpFactory{
    
    public function createRdp(string $ip, string $content, string $createdAt, string $dueTo): Rdp{
        $sql = Sql::getInstance();
        $q = "INSERT INTO " . Rdp::TABLE_NAME . "
            (ip, content, created_at, due_to)
            VALUES('?', '?', '?', '?')";
        
        $sql->logError(__METHOD__);

        $sql->execPrepared($q, [$ip, $content, $createdAt, $dueTo]);
        $sql->logError(__METHOD__);
        
        $id = $sql->getInsertId();
        return new Rdp($id);
    }
    public function deleteRdp(Rdp $rdp) {
        $sql = Sql::getInstance();
        $sql->query("DELETE FROM ". Rdp::TABLE_NAME ." WHERE id=".$rdp->id."");
        $sql->logError(__METHOD__);
    }
    
}

?>