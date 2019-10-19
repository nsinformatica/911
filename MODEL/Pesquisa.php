<?php

include_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';

class Pesquisa{
    private $id_pesquisa;
    private $tema;
    private $titulo;
    private $status;
    private $descricao;
    private $imagem;
    private $contador;
    private $data_criacao;
    private $usuario;
    private $chave;
    private $publicada;
    
    function __construct() {
        $this->usuario = new Usuario();
    }
            
    function getId_pesquisa() {
        return $this->id_pesquisa;
    }

    function getTema() {
        return $this->tema;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getStatus() {
        return $this->status;
    }

        function getDescricao() {
        return $this->descricao;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getContador() {
        return $this->contador;
    }

    function getData_criacao() {
        return $this->data_criacao;
    }

    function setId_pesquisa($id_pesquisa) {
        $this->id_pesquisa = $id_pesquisa;
    }

    function setTema($tema) {
        $this->tema = $tema;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setContador($contador) {
        $this->contador = $contador;
    }

    function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }
    
    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->Usuario= $usuario;
    }
    
    function getChave() {
        return $this->chave;
    }

    function setChave($chave) {
        $this->chave = $chave;
    }
    function getPublicada() {
        return $this->publicada;
    }

    function setPublicada($publicada) {
        $this->publicada = $publicada;
    }
}