<?php

require_once BASE_DIR . 'DAO' . DS . 'PesquisaDAO.php';

class PesquisaController {
    
    private $pesquisaDAO;
    
    function __construct() {
        $this->pesquisaDAO = new PesquisaDAO();
    }
    
    public function isPesquisa(Usuario $usuario) {
        $sePesquisa = $this->pesquisaDAO->buscaPorUsuario($usuario->getId_usuario())->getId_pesquisa();
        if(empty($sePesquisa)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function cadastrar(Pesquisa $pesquisa, Usuario $usuario) {
        if($pesquisa->getTitulo() != null && trim(strlen($pesquisa->getTitulo()) > 0)) {
            return $this->pesquisaDAO->cadastra($pesquisa, $usuario);
        } else {
            return null;
        }
    }
    
    public function lista(Usuario $usuario, $inicio, $fim) {
        return $this->pesquisaDAO->lista($usuario, $inicio, $fim);
    }
    
    public function contaPesquisas(Usuario $usuario) {
        return count($this->pesquisaDAO->lista($usuario, 0, 10000));
    }

    public function busca($id) {
        return $this->pesquisaDAO->busca($id);
    }
    
    public function edita(Pesquisa $pesquisa) {
        $this->pesquisaDAO->editar($pesquisa);
    }
    
    public function status($status, $id) {
        $this->pesquisaDAO->status($status, $id);
    }
    
    public function publicada($status, $id) {
        $this->pesquisaDAO->publicada($status, $id);
    }
    
    public function contaPesquisa() {
        return $this->pesquisaDAO->contaPesquisa();
    }
    
    public function buscarPorChave($chave) {
        return $this->pesquisaDAO->buscaPorChave($chave);
    }
    
    public function contador(Pesquisa $pesquisa) {
        return $this->pesquisaDAO->contador($pesquisa);
    }
}