<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';
require_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';

class PesquisaDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

  

   public function cadastra(Pesquisa $pesq, Usuario $usuario) {
        try {
        
            $sql = "INSERT INTO tbl_pesquisa (data_criacao, tema, titulo, descricao, imagem, id_usuario, status, chave, publicada)"
                    . " VALUES (NOW(), :tema, :titulo, :descricao, :imagem, :id_usuario, :status, :chave, :publicada)";
                   
            $numId = $this->contaPesquisa() + 1;
            
            $parametros = array(
                
                ":tema" => $pesq->getTema(),
                ":titulo" => $pesq->getTitulo(),
                ":descricao" => $pesq->getDescricao(),
                ":imagem" => $pesq->getImagem(),              
                ":id_usuario" => $usuario->getId_usuario(),
                ":status" => $pesq->getStatus(),
                ":chave" => md5($numId),
                ":publicada" => strtoupper($pesq->getPublicada())
                
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function lista(Usuario $usuario, $inicio, $fim) {
        try {
            $sql = "SELECT data_criacao, tema, titulo, descricao,"
                    . " imagem, id_usuario, status, id_pesquisa, chave, contador "
                    . "FROM tbl_pesquisa WHERE id_usuario = :id_usuario AND status = :status LIMIT :inicio, :fim";

            $pesquisa = [];
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim,
                ":status" => 1,
                ":id_usuario" => $usuario->getId_usuario()
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            
            
            foreach ($retorno as $ln) {
                
                $pesquisa = new Pesquisa();
                $pesquisa->setData_criacao($ln["data_criacao"]);
                $pesquisa->setTema($ln["tema"]);
                $pesquisa->setTitulo($ln["titulo"]);
                $pesquisa->setDescricao($ln["descricao"]);
                $pesquisa->setImagem($ln["imagem"]);
                $pesquisa->setId_pesquisa($ln["id_pesquisa"]);
                $pesquisa->setStatus($ln["status"]);
                $pesquisa->setUsuario($ln["id_usuario"]);
                $pesquisa->setChave($ln["chave"]);
                $pesquisa->setContador($ln["contador"]);
   
                $pesquisas[] = $pesquisa;
            }
            return $pesquisas;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
     public function editar(Pesquisa $pesquisa) {

        try {
            $sql = "UPDATE tbl_pesquisa SET"
                    . " titulo = :titulo, descricao = :descricao, imagem = :imagem, "
                    . "status = :status, tema = :tema"
                    . " WHERE"
                    . " id_pesquisa = :id_pesquisa";

            $parametros = array(
                ":titulo" => $pesquisa->getTitulo(),
                ":descricao" => $pesquisa->getDescricao(),
                ":imagem" => $pesquisa->getImagem(),
                ":status" => $pesquisa->getStatus(),
                ":tema" => $pesquisa->getTema(),
                ":id_pesquisa" =>$pesquisa->getId_pesquisa(),
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
   
      public function busca($id) {
        try {
            $sql = "SELECT id_pesquisa, tema, titulo, descricao, imagem, contador, id_usuario, data_criacao, chave, publicada FROM tbl_pesquisa WHERE id_pesquisa = :id";

            $parametros = array(
                ":id" => $id
            );

            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);
           
            $pesquisa = new Pesquisa();
            $pesquisa->setId_pesquisa($retorno["id_pesquisa"]);
            $pesquisa->setTema($retorno["tema"]);
            $pesquisa->setTitulo($retorno["titulo"]);
            $pesquisa->setDescricao($retorno["descricao"]);
            $pesquisa->setImagem($retorno["imagem"]);
            $pesquisa->setContador($retorno["contador"]);
            $pesquisa->setUsuario($retorno["id_usuario"]);
            $pesquisa->setData_criacao($retorno["data_criacao"]);
            $pesquisa->setChave($retorno["chave"]);
            $pesquisa->setPublicada($retorno["publicada"]);
       
           
            return $pesquisa;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
      
    public function buscaPorUsuario($id) {
        try {
            $sql = "SELECT id_pesquisa, tema, titulo, descricao, imagem, contador, id_usuario, data_criacao, status FROM tbl_pesquisa WHERE id_usuario = :id AND status = :status";

            $parametros = array(
                ":id" => $id,
                ":status" => 1
            );

            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);
           
            $pesquisa = new Pesquisa();
            $pesquisa->setId_pesquisa($retorno["id_pesquisa"]);
            $pesquisa->setTema($retorno["tema"]);
            $pesquisa->setTitulo($retorno["titulo"]);
            $pesquisa->setDescricao($retorno["descricao"]);
            $pesquisa->setImagem($retorno["imagem"]);
            $pesquisa->setContador($retorno["contador"]);
            $pesquisa->setUsuario($retorno["id_usuario"]);
            $pesquisa->setData_criacao($retorno["data_criacao"]);
       
           
            return $pesquisa;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function buscaPorChave($chave) {
        try {
            $sql = "SELECT id_pesquisa, chave FROM tbl_pesquisa WHERE chave = :chave";

            $parametros = array(
                ":chave" => $chave
            );

            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);
           
            return $retorno["id_pesquisa"];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
     public function excluir($id) {
        try {
            $sql = "DELETE FROM tbl_pesquisa WHERE id_usuario = :id";

            $parametros = array(
                ":id" => $id
            );

            $retorno = $this->banco->ExecuteQuery($sql, $parametros);

            return $retorno;
            
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
   
    public function status($status, $id){
           
          try { 
            $sql = "UPDATE tbl_pesquisa SET"
                    . " status = :status"
                    . " WHERE"
                    . " id_pesquisa = :id_pesquisa";
            
            $parametros = array(
                ":status" => $status,
                ":id_pesquisa" => $id
            );
            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } 
        
    }
    
    public function publicada($status, $id){
           
          try { 
            $sql = "UPDATE tbl_pesquisa SET"
                    . " publicada = :status"
                    . " WHERE"
                    . " id_pesquisa = :id_pesquisa";
            
            $parametros = array(
                ":status" => $status,
                ":id_pesquisa" => $id
            );
            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        } 
        
    }
    
    public function contador(Pesquisa $pesquisa){
          try {
            $sql = "UPDATE tbl_pesquisa SET"
                    . " contador = :contador"
                    . " WHERE"
                    . " id_pesquisa = :id_pesquisa";
            
           
            if($pesquisa->getContador() == NULL){
                $pesquisa->setContador(1);
            }else {
                $pesquisa->setContador($pesquisa->getContador() + 1);
            }
               
            $parametros = array(
                ":contador" => $pesquisa->getContador(),
                ":id_pesquisa" =>$pesquisa->getId_pesquisa(),
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
           
           
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function contaPesquisa(){
        try {
            $sql = "SELECT COUNT(*) AS id_pesquisa FROM tbl_pesquisa";

            $retorno = $this->banco->ExecuteQueryOneRow($sql);
            
            return $retorno["id_pesquisa"];
            
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
