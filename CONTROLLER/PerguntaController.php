<?php

require_once BASE_DIR . 'DAO' . DS . 'PerguntaDAO.php';

class PerguntaController {
    
    private $perguntaDAO;
    
    function __construct() {
        $this->perguntaDAO = new PerguntaDAO();
    }
    
    public function cadastra(Pergunta $pergunta) {
        $this->perguntaDAO->cadastra($pergunta);
    }

    public function lista(Pesquisa $pesquisa, $inicio, $fim) {
        return $this->perguntaDAO->lista($pesquisa, $inicio, $fim);
    }
    
    public function contaPerguntas($id) {
        return $this->perguntaDAO->contaPergunta($id);
    }
    
    public function edita(Pergunta $pergunta) {
        return $this->perguntaDAO->editar($pergunta);
    }
    
    public function excluir($id) {
        return $this->perguntaDAO->excluir($id);
    }
}