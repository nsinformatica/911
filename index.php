<?php
$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

session_start();

if (isset($_SESSION["nome_usuario"])) {
    $extra = 'app.php';
    header("Location: http://$host$uri/$extra");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VoteBox</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
        
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
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Entrar</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">Registrar</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="login.php" method="post" role="form" style="display: block;">
                                        <div class="form-group">
                                            <input type="text" name="email" id="username" tabindex="1" class="form-control" placeholder="Email" value="" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="senha" id="password" tabindex="2" class="form-control" placeholder="Senha">
                                        </div>
                                        <!--<div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> Lembras minha senha</label>
                                        </div>-->
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Entrar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <!--<a href="recupera-senha.php" tabindex="5" class="forgot-password">Esqueci minha senha!</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="register-form" action="cadastra-usuario.php" method="POST" role="form" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" name="nome" id="nome" tabindex="1" class="form-control" placeholder="Nome Completo" value="" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="2" class="form-control" placeholder="Email" value="" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="telefone" id="telefone" tabindex="5" class="form-control" placeholder="Telefone - (00) 0 0000-0000" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="senha" id="senha" tabindex="3" class="form-control" placeholder="Senha" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm-password" id="confirm-password" tabindex="4" class="form-control" placeholder="Confirme sua senha" required="">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registrar">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $msgCadUser = filter_input(INPUT_GET, "msg");
        if ($msgCadUser != null) {
            echo "<script>alert('$msgCadUser');</script>";
        }
        ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>
