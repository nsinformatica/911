<?php
$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

include_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';

$usuario = new Usuario();

session_start();

if ($_SESSION["nome_usuario"] == null) {
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
} else {
    $usuario->setNome($_SESSION["nome_usuario"]);
    $usuario->setEmail($_SESSION["email_usuario"]);
    $usuario->setId_usuario($_SESSION["id_usuario"]);
    $usuario->setImagem($_SESSION["img_usuario"]);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Pesquisas - NS Informática</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/estilo.css" rel="stylesheet">

        <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>

        <link rel="icon" href="imagens/icon.ico" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="app.php"><img alt="Logo VotoBox" src="imagens/logo.png" class="" style="max-height: 30px;" /></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="app.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</span></a></li>
                            <li><a href="app.php?page=usuario"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Minha Conta</a></li>
                            <li><a href="app.php?page=contato"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Reportar Erro</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Sair</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php
            $pg = filter_input(INPUT_GET, "page");

            switch ($pg) {
                case "pesquisa":
                    require_once BASE_DIR . 'VIEW' . DS . 'pesquisa.php';
                    break;
                case "dados":
                    require_once BASE_DIR . 'VIEW' . DS . 'dados.php';
                    break;
                case "usuario":
                    require_once BASE_DIR . 'VIEW' . DS . 'usuario.php';
                    break;
                case "logica":
                    require_once BASE_DIR . 'VIEW' . DS . 'logica.php';
                    break;
                case "contato":
                    require_once BASE_DIR . 'VIEW' . DS . 'contato.php';
                    break;
                default:
                    require_once BASE_DIR . 'VIEW' . DS . 'dashboard.php';
            }
            ?>
            <!-- Fim da parte dinâmica-->
            <footer>
                <div class="well">&COPY; <strong>NS Informática</strong> todos os direitos reservados, (77) 9 9122-2146</div>
            </footer>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
