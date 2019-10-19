<?php

include_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';

class Contato {
    
    private $IdContato;
    private $idUsuario;
    private $tipo;
    private $mensagem;
    
    function __construct() {
        $this->idUsuario = new Usuario();
    }
    
    function getIdContato() {
        return $this->IdContato;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setIdContato($IdContato) {
        $this->IdContato = $IdContato;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

}