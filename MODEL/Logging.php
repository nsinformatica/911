<?php

class Logging{
    private $id_log;
    private $descricao;
    private $responsavel;
    private $data_criacao;
    
    function getId_log() {
        return $this->id_log;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getResponsavel() {
        return $this->responsavel;
    }
    function getData_criacao() {
        return $this->data_criacao;
    }

    function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

        function setId_log($id_log) {
        $this->id_log = $id_log;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }


    
}
