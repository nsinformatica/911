<?php

require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'IpAcesso.php';

class IpAcessoDAO {
    
    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

    public function cadastra(IpAcesso $ipAcesso) {
        try {
            $sql = "INSERT INTO tbl_ip_acesso (ip_acesso, data_acesso) VALUES (:ip, :data)";

            $parametros = array(
                ":ip" => $ipAcesso->getIpAcesso(),
                ":data" => $ipAcesso->getData()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
        
    public function valida($ip, $data) {
        try {
            $sql = "SELECT ip_acesso, data_acesso FROM tbl_ip_acesso "
                    . "WHERE ip_acesso LIKE '" . $ip . "' AND data_acesso LIKE '" . $data . "' ";
            
            $retorno = $this->banco->ExecuteQuery($sql);
           
            return count($retorno);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
