<?php

$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

require_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'UsuarioController.php';
require_once BASE_DIR . 'Utilitarios' . DS . 'LogUtil.php';


$log = new LogUtil();

$email = filter_input(INPUT_POST, "email");
$senha = filter_input(INPUT_POST, "senha");

$usuario = new Usuario();
$usuarioController = new UsuarioController();

session_start();

$usuarioBanco = $usuarioController->login($email, $senha);

if ($usuarioBanco->getId_usuario() != null) {
    $_SESSION["nome_usuario"] = $usuarioBanco->getNome();
    $_SESSION["id_usuario"] = $usuarioBanco->getId_usuario();
    $_SESSION["email_usuario"] = $usuarioBanco->getEmail();
    $_SESSION["img_usuario"] = $usuarioBanco->getImagem();

    $extra = 'app.php';
    
    $log->log("Usuario acessou o sistema", $usuarioBanco);
} else {
    $usuario = new Usuario();
    $usuario->setEmail($email);
    $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    $log->log("Tentativa de acesso não autorizada pelo IP: " . $ip, $usuario, 'error');
    $extra = 'index.php?msg=Usuario e senha estão incorretos!';
}

header("Location: http://$host$uri/$extra");
