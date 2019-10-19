<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Itens_pergunta.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';

class Itens_perguntaDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }
    
    public function cadastra(Itens_pergunta $Itens_pergunta) {
        try {
            $sql = "INSERT INTO tbl_itens_pergunta (numero, imagem, descricao, id_pergunta)"
                    . " VALUES (:numero, :imagem, :descricao, :id_pergunta)";
               
            $parametros = array(
                
                ":numero" => intval($Itens_pergunta->getNumero()),
                ":imagem" => $Itens_pergunta->getImagem(),
                ":descricao" => $Itens_pergunta->getDescricao(),
                ":id_pergunta" => $Itens_pergunta->getPergunta()
                                
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function lista(Pergunta $idPergunta, $inicio, $fim) {
        try {
            $sql = "SELECT id_itens_pergunta,numero , imagem, descricao, id_pergunta "
                    . "FROM tbl_itens_pergunta WHERE id_pergunta = :id_pergunta ORDER BY numero LIMIT :inicio, :fim ";

            $Ipergunta = [];
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim,
                ":id_pergunta" => $idPergunta->getId_pergunta()
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            foreach ($retorno as $ln) {
                $ItperguntaI = new Itens_pergunta();
                
                $ItperguntaI->setId_itens_pergunta($ln["id_itens_pergunta"]);
                $ItperguntaI->setNumero($ln["numero"]);
                $ItperguntaI->setImagem($ln["imagem"]);
                $ItperguntaI->setDescricao($ln["descricao"]);
                $ItperguntaI->setPergunta($ln["id_pergunta"]);
               
               
                $Ipergunta[] = $ItperguntaI;
            }
            return $Ipergunta;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function editar(Itens_pergunta $itens_pergunta) {

        try {
            $sql = "UPDATE tbl_itens_pergunta SET"
                    . " numero = :numero, imagem = :imagem, descricao = :descricao, texto = :texto "
                    . "  WHERE"
                    . " id_itens_pergunta = :id_itens_pergunta";

            $parametros = array(
                ":numero" => $itens_pergunta->getNumero(),
                ":imagem" => $itens_pergunta->getImagem(),
                ":descricao" =>$itens_pergunta->getDescricao(),
                ":texto" =>$itens_pergunta->getTexto(),
                ":id_itens_pergunta" =>$itens_pergunta->getId_itens_pergunta()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function busca($id) {
        try {
            $sql = "SELECT id_itens_pergunta, numero, imagem, descricao, id_pergunta"
                    . " FROM tbl_itens_pergunta WHERE id_itens_pergunta = :id";

            $parametros = array(
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $ItensPergunta = new Itens_pergunta();
            $ItensPergunta->setId_itens_pergunta($retorno["id_itens_pergunta"]);
            $ItensPergunta->setNumero($retorno["numero"]);
            $ItensPergunta->setImagem($retorno["imagem"]);
            $ItensPergunta->setDescricao($retorno["descricao"]);
            $ItensPergunta->setPergunta($retorno["id_pergunta"]);
            
            return $ItensPergunta;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function pegaUmtimoID() {
        try {
            $sql = "SELECT id_itens_pergunta FROM tbl_itens_pergunta ORDER BY id_itens_pergunta DESC LIMIT 1";

            $retorno = $this->banco->ExecuteQueryOneRow($sql);
         
            return $retorno["id_itens_pergunta"];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function contaItens($id) {
        try {
            $sql = "SELECT COUNT(*) AS numero FROM tbl_itens_pergunta WHERE id_pergunta = :id";
            $parametros = array(
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $ItensPergunta = new Itens_pergunta();
            $ItensPergunta->setNumero($retorno["numero"]);

            return $ItensPergunta->getNumero();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM tbl_itens_pergunta WHERE id_itens_pergunta = :id";

            $parametros = array(
                ":id" => $id
            );
            
            return $this->banco->ExecuteQuery($sql, $parametros);
            
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}