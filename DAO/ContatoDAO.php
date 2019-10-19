<?php
require_once BASE_DIR . 'Banco' . DS . 'Banco.php';
require_once BASE_DIR . 'MODEL' . DS . 'Contato.php';

class ContatoDAO {

    private $banco;

    function __construct() {
        $this->banco = new Banco();
    }

    function __destruct() {
        $this->banco->Disconnect();
    }

    public function cadastra(Contato $contato) {
        try {
            $sql = "INSERT INTO tbl_contato (id_usuario, tipo, mensagem)"
                    . " VALUES (:id_usuario, :tipo, :mesagem)";

            $parametros = array(
                ":id_usuario" => $contato->getIdUsuario(),
                ":tipo" => $contato->getTipo(),
                ":mesagem" => $contato->getMensagem()
            );

            return $this->banco->ExecuteNonQuery($sql, $parametros);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
