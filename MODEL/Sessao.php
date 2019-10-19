<?php
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';

class Sessao {
    
    private $id_sessao;
    private $descricao;
    private $pesquisa;
    
    function __construct() {
        $this->pesquisa = new Pesquisa();
    }

    function getId_sessao() {
        return $this->id_sessao;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getPesquisa() {
        return $this->pesquisa;
    }

    function setId_sessao($id_sessao) {
        $this->id_sessao = $id_sessao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setPesquisa($pesquisa) {
        $this->pesquisa = $pesquisa;
    }

}
