<?php

require_once BASE_DIR . 'DAO' . DS . 'UsuarioDAO.php';

class UsuarioController {

    private $usuarioDAO;

    function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function cadastra(Usuario $usuario) {
        if (trim(strlen($usuario->getNome()) > 0) && trim(strlen($usuario->getEmail()) > 0) && trim(strlen($usuario->getSenha()) > 0)) {
            return $this->usuarioDAO->cadastra($usuario);
        } else {
            return false;
        }
    }
    
    public function login($email, $senha) {
        return $this->usuarioDAO->login($email, $senha);
    }
    
    public function editar(Usuario $usuaio) {
        $this->usuarioDAO->editar($usuaio);
    }
    
    public function buscar($id) {
        return $this->usuarioDAO->busca($id);
    }

}