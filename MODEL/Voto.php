<?php

include_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
include_once BASE_DIR . 'MODEL' . DS . 'Itens_pergunta.php';

class Voto {

    private $id_voto;
    private $pergunta;
    private $itens_pergunta;
    private $texto;
    private $escala;

    function __construct() {
        $this->pergunta = new Pergunta();
        $this->itens_pergunta = new Itens_pergunta();
    }

    function getId_voto() {
        return $this->id_voto;
    }

    function getPergunta() {
        return $this->pergunta;
    }

    function getItens_pergunta() {
        return $this->itens_pergunta;
    }

    function setPergunta($pergunta) {
        $this->pergunta = $pergunta;
    }

    function setItens_pergunta($itens_pergunta) {
        $this->itens_pergunta = $itens_pergunta;
    }

    function setId_voto($id_voto) {
        $this->id_voto = $id_voto;
    }
    function getTexto() {
        return $this->texto;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }
    function getEscala() {
        return $this->escala;
    }

    function setEscala($escala) {
        $this->escala = $escala;
    }
}