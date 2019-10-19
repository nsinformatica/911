<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Voto.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
require_once BASE_DIR . 'MODEL' . DS . 'Itens_pergunta.php';
require_once BASE_DIR . 'DAO' . DS . 'PesquisaDAO.php';

class VotoDAO {

    private $banco;
    private $pesquisaDAO;

    function __construct() {
        $this->banco = new Banco();
        $this->pesquisaDAO = new PesquisaDAO();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }
   
    public function cadastra(Voto $voto, Pesquisa $pesquisa) {
        try {
        
            $sql = "INSERT INTO tbl_voto ( id_item_pergunta, id_pergunta, texto, escala)"
                    . " VALUES ( :id_item_pergunta, :id_pergunta, :texto, :escala)";
                   
            
            $parametros = array(
                
                ":id_item_pergunta" => $voto->getItens_pergunta(),
                ":id_pergunta" =>  $voto->getPergunta(),
                ":escala" =>  $voto->getEscala(),
                ":texto" => $voto->getTexto()
            );
           
            if ($this->banco->ExecuteNonQuery($sql, $parametros)) {
                $this->pesquisaDAO->contador($pesquisa);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function lista($inicio, $fim) {
        try {
            $sql = "SELECT id_item_pergunta,id_pergunta, id_voto "
                    . "FROM tbl_voto LIMIT :inicio, :fim";

            $voto = [];
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            foreach ($retorno as $ln) {
                $voto = new Voto();
                $voto->setId_voto($ln["id_voto"]);
                $voto->setItens_pergunta($ln["id_item_pergunta"]);
                $voto->setPergunta($ln["id_pergunta"]);
               
               
                $votos[] = $voto;
            }
            return $votos;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function listaPorPergunta($id) {
        try {
            $sql = "SELECT id_item_pergunta,id_pergunta, id_voto, texto, escala "
                    . "FROM tbl_voto WHERE id_pergunta = :id";

            $votos = [];
            
            $parametros = array (
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            foreach ($retorno as $ln) {
                $voto = new Voto();
                $voto->setId_voto($ln["id_voto"]);
                $voto->setItens_pergunta($ln["id_item_pergunta"]);
                $voto->setPergunta($ln["id_pergunta"]);
                $voto->setTexto($ln["texto"]);
                $voto->setEscala($ln["escala"]);
               
               
                $votos[] = $voto;
            }
            return $votos;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function contaVoto($idPergunta, $idItem) {
        try {
            $sql = "SELECT id_item_pergunta, id_pergunta, id_voto "
                    . "FROM tbl_voto WHERE id_pergunta = :id_pergunta AND id_item_pergunta = :id_item";
            
            $parametros = array (
                ":id_pergunta" => $idPergunta,
                ":id_item" => $idItem
            );
            
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            
            $cont = 0;
            foreach ($retorno as $ln) {
                $cont++;
            }
            return $cont;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
        
    public function busca($id) {
        try {
            $sql = "SELECT id_voto, id_pergunta, id_item_pergunta"
                    . " FROM tbl_voto WHERE id_voto = :id";

            $parametros = array(
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $voto = new Voto();
            $voto->setId_voto($retorno["id_voto"]);
            $voto->setItens_pergunta($retorno["id_item_pergunta"]);
            $voto->setPergunta($retorno["id_pergunta"]);
         
            return $voto;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function excluir($id) {
        try {
            $sql = "DELETE FROM tbl_voto WHERE id_voto = :id";

            $parametros = array(
                ":id" => $id
            );

            $retorno = $this->banco->ExecuteQuery($sql, $parametros);

            return $retorno;
            
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    
    
    
}