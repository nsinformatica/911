<?php
$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

include_once './DAO/VotoDAO.php';
include_once './DAO/IpAcessoDAO.php';
include_once './DAO/Itens_perguntaDAO.php';
include_once './CONTROLLER/PerguntaController.php';
include_once './CONTROLLER/PesquisaController.php';

include_once './MODEL/Itens_pergunta.php';
include_once './MODEL/Voto.php';
include_once './MODEL/Pesquisa.php';
include_once './MODEL/IpAcesso.php';
include_once './Utilitarios/LogUtil.php';

include_once './recaptchalib.php';

$perguntaControlle = new PerguntaController();
$pesquisaControlle = new PesquisaController();

$votoDAO = new VotoDAO();
$itensPerguntaDAO = new Itens_perguntaDAO();

$codPesquisa = filter_input(INPUT_GET, "codPesquisa");

$voto = new Voto();
$pesquisa = new Pesquisa();
$pesquisa->setId_pesquisa($codPesquisa);

$pesquisaN = $pesquisaControlle->busca($codPesquisa);

$log = new LogUtil();

//o Secret do Captcha Google deve ser preenxido
$secret = "";
$response = null;
$captcha = new ReCaptcha($secret);

$ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

$ipAcessoDAO = new IpAcessoDAO();

if ($_POST["g-recaptcha-response"]) {
    $response = $captcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]
    );
}

$mensagem = "";

if (!strcmp(filter_input(INPUT_GET, "action"), "gravar")) {
//   if ($response != null && $response->success) {

        if ($ipAcessoDAO->valida($ip, date("Y-m-d")) > 99999999) {
            $extra = 'cadVoto.php?action=ipError';
            header("Location: http://$host$uri/$extra");
        } else {
            $ipAcesso = new IpAcesso();
            $ipAcesso->setIpAcesso($ip);
            $ipAcesso->setData(date("Y-m-d"));
            $ipAcessoDAO->cadastra($ipAcesso);

            foreach ($_POST as $campo => $valor) {

                $tipoCampo = explode("-", $campo)[0];
                $idCampo = explode("-", $campo)[1];

                echo $tipoCampo;

                if (!strcmp($tipoCampo, "radio")) {
                    $voto->setItens_pergunta($valor);
                    $voto->setPergunta($idCampo);
                    $voto->setEscala(null);
                    $voto->setTexto(null);
                    $votoDAO->cadastra($voto, $pesquisa);
                } else if (!strcmp($tipoCampo, "texto")) {
                    $voto->setItens_pergunta(null);
                    $voto->setPergunta($idCampo);
                    $voto->setTexto($valor);
                    $voto->setEscala(null);
                    $votoDAO->cadastra($voto, $pesquisa);
                } else if (!strcmp($tipoCampo, "escala")) {
                    $voto->setItens_pergunta(null);
                    $voto->setTexto(null);
                    $voto->setPergunta($idCampo);
                    $voto->setEscala($valor);
                    $votoDAO->cadastra($voto, $pesquisa);
                }
            }

            $pesquisaControlle->contador($pesquisaN);

            $usuario = new Usuario();
            $usuario->setEmail("Usuario não indentificado!");
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            $log->log("Voto registrado com - usuário com IP: " . $ip, $usuario);

            $extra = 'cadVoto.php?action=sucesso';
            header("Location: http://$host$uri/$extra");
        }
    } else {
        $mensagem = "Erro ao validar sua opnião!";
    }
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "sucesso")) {
    $mensagem = "Opinião registrada com sucesso!";
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "ipError")) {
    $mensagem = "Você excedeu o limite de votos!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Voto Confirmado</title>

        <link href="https://fonts.googleapis.com/css?family=Patua+One|Raleway" rel="stylesheet"> 

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/estilo_cadVoto.css" rel="stylesheet">

        <link rel="icon" href="imagens/icon.ico" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="topo">
            <div class="container">
                <div class="col-md-7 col-xs-12">
                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <br />
                            <br />
                            <img src="imagens/IconeVoteBox.png" alt="Icone VoteBox" class="img-responsive" />
                        </div>
                    </div>
                    <p><?= $mensagem ?></p>
                </div>
                <div class="col-md-5 col-xs-12">
                    <div class="row">
                        <div class="col-md-4 col-xs-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
