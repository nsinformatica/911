<?php
include_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';

class Pergunta{
    private $id_pergunta;
    private $tipo;
    private $pergunta;
    private $pesquisa;
    private $status;
    private $obrigatorio; 
    
     
    function __construct() {
        $this->pesquisa = new Pesquisa();
    }
          
    
    function getId_pergunta() {
        return $this->id_pergunta;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getPergunta() {
        return $this->pergunta;
    }

    function getPesquisa() {
        return $this->pesquisa;
    }
    
    function getObrigatorio() {
        return $this->obrigatorio;
    }

    function setObrigatorio($obrigatorio) {
        $this->obrigatorio = $obrigatorio;
    }

    function setPesquisa($pesquisa) {
        $this->pesquisa = $pesquisa;
    }

    function setId_pergunta($id_pergunta) {
        $this->id_pergunta = $id_pergunta;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setPergunta($pergunta) {
        $this->pergunta = $pergunta;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

}
