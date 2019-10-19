<?php

require_once BASE_DIR . 'MODEL' . DS . 'Logging.php';
require_once BASE_DIR . 'DAO' . DS . 'LoggingDAO.php';

class LogUtil {
    
    private $loggingDAO;
    
    function __construct() {
        $this->loggingDAO = new LoggingDAO();
    }

        function log($msg, Usuario $usuario, $level = 'info') {
        // variável que vai armazenar o nível do log (INFO, WARNING ou ERROR)
        $levelStr = '';

        // verifica o nível do log
        switch ($level) {
            case 'info':
                // nível de informação
                $levelStr = 'INFO';
                break;

            case 'warning':
                // nível de aviso
                $levelStr = 'WARNING';
                break;

            case 'error':
                // nível de erro
                $levelStr = 'ERROR';
                break;
        }

        // data atual
        $date = date('Y-m-d H:i:s');

        // formata a mensagem do log
        // 1o: data atual
        // 2o: nível da mensagem (INFO, WARNING ou ERROR)
        // 3o: a mensagem propriamente dita
        // 4o: uma quebra de linha
        $retorno = sprintf("[%s] [%s]: %s%s", $date, $levelStr, $msg, PHP_EOL);
        
        $log = new Logging();
        $log->setDescricao($retorno);
        $log->setData_criacao(date('d/m/y'));
        $log->setResponsavel($usuario->getEmail());
        
        $this->loggingDAO->cadastra($log);
    }

}
