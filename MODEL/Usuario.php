<?php

class Usuario{
    private $id_usuario;
    private $nome;
    private $email;
    private $senha;
    private $imagem;
    private $documento;
    private $telefone; 
   

    function getId_usuario() {
        return $this->id_usuario;
    }

    public function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getTelefone() {
        return $this->telefone;
    }

        function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }


}
    

    
    