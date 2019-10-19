<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';

class PerguntaDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }
    
    
    public function cadastra(Pergunta $pergunta) {
        try {
        
            $sql = "INSERT INTO tbl_pergunta (tipo, pergunta, id_pesquisa, status, obrigatorio)"
                    . " VALUES (:tipo, :pergunta, :id_pesquisa, :status, :obrigatorio)";
                   
       
            $parametros = array(
                
                ":tipo" => $pergunta->getTipo(),
                ":pergunta" => $pergunta->getPergunta(),
                ":status" => 1,
                ":id_pesquisa" => $pergunta->getPesquisa(),
                ":obrigatorio" => $pergunta->getObrigatorio()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function lista(Pesquisa $pesquisa, $inicio, $fim) {
        try {
            $sql = "SELECT id_pergunta,tipo, pergunta, id_pesquisa, status, obrigatorio "
                    . "FROM tbl_pergunta WHERE id_pesquisa = :id_pesquisa AND status = :status LIMIT :inicio, :fim";

            $perguntas = [];
            
            $parametros = array (
                ":status" => 1,
                ":inicio" => $inicio,
                ":fim" => $fim,
                ":id_pesquisa" => $pesquisa->getId_pesquisa()
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            foreach ($retorno as $ln) {
                $pergunta = new Pergunta();
                $pergunta->setId_pergunta($ln["id_pergunta"]);
                $pergunta->setPergunta($ln["pergunta"]);
                $pergunta->setTipo($ln["tipo"]);
                $pergunta->setPesquisa($ln["id_pesquisa"]);
                $pergunta->setObrigatorio($ln["obrigatorio"]);
                $perguntas[] = $pergunta;
            }
            return $perguntas;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function contaPergunta($id) {
        try {
            $sql = "SELECT * FROM tbl_pergunta "
                    . "INNER JOIN tbl_pesquisa ON tbl_pergunta.id_pesquisa = tbl_pesquisa.id_pesquisa "
                    . "WHERE tbl_pesquisa.id_usuario = :id_usuario AND tbl_pesquisa.status = :status AND tbl_pergunta.status = :status_P";
            
            $parametros = array (
                ":id_usuario" => $id,
                ":status" => 1,
                ":status_P" => 1
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
    public function editar(Pergunta $pergunta) {
        try {
            $sql = "UPDATE tbl_pergunta SET"
                    . " tipo = :tipo, pergunta = :pergunta, obrigatorio = :obrigatorio "
                    . "  WHERE"
                    . " id_pergunta = :id_pergunta";

            $parametros = array(
                ":tipo" =>$pergunta->getTipo(),
                ":pergunta" =>$pergunta->getPergunta(),
                ":id_pergunta" =>$pergunta->getId_pergunta(),
                ":obrigatorio" =>$pergunta->getObrigatorio()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function busca($id) {
        try {
            $sql = "SELECT id_pergunta, tipo, pergunta, id_pesquisa, obrigatorio"
                    . " FROM tbl_pergunta WHERE id_pergunta = :id";

            $parametros = array(
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $pergunta = new Pergunta();
            $pergunta->setId_pergunta($retorno["id_pesquisa"]);
            $pergunta->setPergunta($retorno["pergunta"]);
            $pergunta->setTipo($retorno["tipo"]);
            $pergunta->setObrigatorio($retorno["obrigatorio"]);
         
            return $pergunta;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
      public function excluir($id) {
        try {
            $sql = "UPDATE tbl_pergunta SET"
                    . " status = :status "
                    . "  WHERE"
                    . " id_pergunta = :id_pergunta";

            $parametros = array(
                ":status" => 0,
                ":id_pergunta" => $id,
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    
    
}