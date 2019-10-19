<?php
include_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';

class Itens_pergunta{
    private $id_itens_pergunta;
    private $numero;
    private $imagem;
    private $descricao;
    private $pergunta;
            
    function __construct() {
        $this->pergunta = new Pergunta();
    }
    
    function getId_itens_pergunta() {
        return $this->id_itens_pergunta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getDescricao() {
        return $this->descricao;
    }
    function getPergunta() {
        return $this->pergunta;
    }

    function setPergunta($pergunta) {
        $this->pergunta = $pergunta;
    }

    function setId_itens_pergunta($id_itens_pergunta) {
        $this->id_itens_pergunta = $id_itens_pergunta;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}
