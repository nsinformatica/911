<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', (dirname(__FILE__)) . DS);

include_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';
include_once BASE_DIR . 'DAO' . DS . 'UsuarioDAO.php';

include_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';
include_once BASE_DIR . 'DAO' . DS . 'PesquisaDAO.php';

include_once BASE_DIR . 'MODEL' . DS . 'Logging.php';
include_once BASE_DIR . 'DAO' . DS . 'LoggingDAO.php';

include_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
include_once BASE_DIR . 'DAO' . DS . 'PerguntaDAO.php';

require_once BASE_DIR . 'MODEL' . DS . 'Itens_pergunta.php';
include_once BASE_DIR . 'DAO' . DS . 'Itens_perguntaDAO.php';

require_once BASE_DIR . 'MODEL' . DS . 'Voto.php';
include_once BASE_DIR . 'DAO' . DS . 'VotoDAO.php';

$pesquisa = new Pesquisa();
$pesDAO = new PesquisaDAO();
        
$log = new Logging();
$logDAO = new LoggingDAO();

$usuario = new Usuario();
$usoDAO = new UsuarioDAO();

$pergunta = new Pergunta();
$perguntaDAO = new PerguntaDAO();

$iten = new Itens_pergunta();
$itendao = new Itens_perguntaDAO();

$voto = new Voto();
$votoDAO = new VotoDAO();
/*

$usuario->setDocumento("22155623");
$usuario->setEmail("stanellejulle@hotmail.com");
$usuario->setImagem("foto");
$usuario->setNome("stanelle");
$usuario->setSenha("12335");
$usuario->setTelefone("991686787");
$usoDAO->cadastra($usuario);

$log->setDescricao("prefeitura");
$log->setResponsavel("Lucas");
$logDAO->cadastra($log);
 
$idusuario=$usoDAO->busca(1);
print_r($idusuario);
$pesquisa->setDescricao("pesquisa realizada para testes");
$pesquisa->setImagem("foto");
$pesquisa->setTema("teste");
$pesquisa->setTitulo("pesqusia teste");
$pesquisa->setStatus("0");
$pesDAO->cadastra($pesquisa, $idusuario);

$ResulPesquisa = $pesDAO->busca(1);
$pesDAO->contador($ResulPesquisa);


$ResulPesquisa = $pesDAO->busca(1);
$pergunta->setPergunta("Qual é nome mais bonito?");
$pergunta->setPesquisa("Você deverá escolher uma alternativa");
$pergunta->setTipo(1);
$perguntaDAO->cadastra($pergunta, $ResulPesquisa);



$iten->setDescricao("Stanelle");
$iten->setEscala(1);
$iten->setImagem("foto");
$iten->setNumero(1);

$perguntaResp=$perguntaDAO->busca(1);

print_r($perguntaResp);
$itendao->cadastra($iten, $perguntaResp);



$res = $itendao->busca(2); 
$resul= $res->getPergunta();
$so = $perguntaDAO->busca($resul);
print_r($so);
print_r($res);

$votoDAO->cadastra($res, $so);
 * 
 */