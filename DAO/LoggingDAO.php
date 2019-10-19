<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Logging.php';


class LoggingDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

  

    public function cadastra(Logging $log) {
        try {
            $sql = "INSERT INTO tbl_logging ( descricao, responsavel, data_criacao)"
                    . " VALUES ( :descricao, :responsavel,  NOW())";

            $parametros = array(
                ":descricao" => $log->getDescricao(),
                ":responsavel" => $log->getResponsavel(),
             
                 
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function visualizar($inicio, $fim) {
        try {
            
            $sql = "SELECT id_logging, descricao, responsavel, data_criacao FROM tbl_logging LIMIT :inicio, :fim";

            $log = [];
            
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
           
            
            foreach ($retorno as $ln) {
                $log = new Logging();
                $log->setId_log($ln["id_logging"]);
                $log->setDescricao($ln["descricao"]);
                $log->setResponsavel($ln["responsavel"]);
                $log->setData_criacao(date('d-m-Y', strtotime($ln["data_criacao"])));
                
                $logs[] = $log;
            }
            return $logs;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }   
        
    public function busca($inicio, $fim, $data_inicio, $data_fim) {
        try {
            
            $dti = date('Y-m-d', strtotime($data_inicio));
            $dtf = date('Y-m-d', strtotime($data_fim));
            
            $log = [];

            $sql = "SELECT data_criacao, id_logging, descricao, responsavel FROM tbl_logging "
                    . " WHERE  data_criacao BETWEEN ('" . $dti . "') AND ('" . $dtf . "')"
                    . " LIMIT :inicio, :fim";
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim
            );
            
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
           
            
            foreach ($retorno as $ln) {
                $log = new Logging();
                $log->setId_log($ln["id_logging"]);
                $log->setDescricao($ln["descricao"]);
                $log->setResponsavel($ln["responsavel"]);
                $log->setData_criacao(date('d-m-Y', strtotime($ln["data_criacao"])));
               
                $logs[] = $log;
            }
            return $logs;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}