<?php


require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';

class UsuarioDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

    public function cadastra(Usuario $usuario) {
        try {
            $sql = "INSERT INTO tbl_usuario (nome, email, senha, imagem, documento, telefone)"
                    . " VALUES (:nome, :email, :senha, :imagem, :documento, :telefone)";

            $parametros = array(
                ":nome" => $usuario->getNome(),
                ":email" => $usuario->getEmail(),
                ":senha" => $usuario->getSenha(),
                ":imagem" => $usuario->getImagem(),
                ":documento" => $usuario->getDocumento(),
                ":telefone" => $usuario->getTelefone(),
                
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function lista($inicio, $fim) {
        try {
            $sql = "SELECT id_usuario, nome, email, senha, imagem, documento, telefone FROM tbl_usuario LIMIT :inicio, :fim";

            $usuarios = [];
            
            $parametros = array (
                ":inicio" => $inicio,
                ":fim" => $fim
            );
            $retorno = $this->banco->ExecuteQuery($sql, $parametros);
            foreach ($retorno as $ln) {
                $usuario = new Usuario();
                $usuario->setId_usuario($ln['id_usuario']);
                $usuario->setNome($ln['nome']);
                $usuario->setEmail($ln['email']);
                $usuario->setSenha($ln['senha']);
                $usuario->setImagem($ln['imagem']);
                $usuario->setDocumento($ln['documento']);
                $usuario->setTelefone($ln['telefone']);

                $usuarios[] = $usuario;
            }
            return $usuarios;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function editar(Usuario $usuario) {

        try {
            $sql = "UPDATE tbl_usuario SET"
                    . " nome = :nome, email = :email, senha = :senha, imagem = :imagem,  documento = :documento,  telefone = :telefone"
                    . " WHERE"
                    . " id_usuario = :id_usuario";
            $parametros = array(
                ":nome" => $usuario->getNome(),
                ":email" => $usuario->getEmail(),
                ":senha" => $usuario->getSenha(),
                ":imagem" => $usuario->getImagem(),
                ":documento" => $usuario->getDocumento(),
                ":telefone" => $usuario->getTelefone(),
                ":id_usuario"=> $usuario->getId_usuario()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function busca($id) {
        try {
            $sql = "SELECT id_usuario, nome, email, senha, imagem, "
                    . "documento, telefone "
                    . " FROM tbl_usuario WHERE id_usuario = :id";

            $parametros = array(
                ":id" => $id
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $usuario = new Usuario();
            $usuario->setId_usuario($retorno['id_usuario']);
            $usuario->setNome($retorno['nome']);
            $usuario->setEmail($retorno["email"]);
            $usuario->setSenha($retorno['senha']);
            $usuario->setImagem($retorno["imagem"]);
            $usuario->setDocumento($retorno["documento"]);
            $usuario->setTelefone($retorno["telefone"]);
            
            return $usuario;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function login($email, $senha) {
        try {
            $sql = "SELECT id_usuario, nome, email, senha, imagem, "
                    . "documento, telefone "
                    . " FROM tbl_usuario WHERE email LIKE :email AND senha LIKE :senha";

            $parametros = array(
                ":email" => $email,
                ":senha" => $senha
            );
            $retorno = $this->banco->ExecuteQueryOneRow($sql, $parametros);

            $usuario = new Usuario();
            $usuario->setId_usuario($retorno['id_usuario']);
            $usuario->setNome($retorno['nome']);
            $usuario->setEmail($retorno["email"]);
            $usuario->setSenha($retorno['senha']);
            $usuario->setImagem($retorno["imagem"]);
            $usuario->setDocumento($retorno["documento"]);
            $usuario->setTelefone($retorno["telefone"]);
            
            return $usuario;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM tbl_usuario WHERE id_usuario = :id";

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
