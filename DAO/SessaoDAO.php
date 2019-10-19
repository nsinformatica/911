<?php

require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Sessao.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';

class SessaoDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

    public function cadastra(Sessao $sessao) {
        try {
            $sql = "INSERT INTO tbl_sessao (descricao, id_pesquisa)"
                    . " VALUES (:descricao, :id_pesquisa)";

            $parametros = array(
                ":descricao" => $sessao->getDescricao(),
                ":id_pesquisa" => $sessao->getPesquisa()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
