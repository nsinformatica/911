<?php

$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

require_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'UsuarioController.php';

$nome = filter_input(INPUT_POST, "nome");
$email = filter_input(INPUT_POST, "email");
$telefone = filter_input(INPUT_POST, "telefone");
$senha = filter_input(INPUT_POST, "senha");

$usuario = new Usuario();
$usuarioController = new UsuarioController();

$usuario->setNome($nome);
$usuario->setEmail($email);
$usuario->setTelefone($telefone);
$usuario->setSenha($senha);

$usuarioController->cadastra($usuario);

$extra = 'index.php';
header("Location: http://$host$uri/$extra?msg=Usuario cadastrado com sucesso!");