<?php
require_once BASE_DIR . 'MODEL' . DS . 'Usuario.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'UsuarioController.php';
require_once BASE_DIR . 'Utilitarios' . DS . 'LogUtil.php';


$log = new LogUtil();
$usuarioController = new UsuarioController();

$usuarioBanco = $usuarioController->buscar($usuario->getId_usuario());

if (!strcmp(filter_input(INPUT_GET, "action"), "edit")) {
    $usuarioEdita = new Usuario();
    $usuarioEdita->setId_usuario($usuario->getId_usuario());
    $usuarioEdita->setNome(filter_input(INPUT_POST, "nome"));
    $usuarioEdita->setDocumento(filter_input(INPUT_POST, "documento"));
    $usuarioEdita->setTelefone(filter_input(INPUT_POST, "telefone"));
    $usuarioEdita->setEmail($usuario->getEmail());
    $usuarioEdita->setSenha(filter_input(INPUT_POST, "senha"));

    if (!empty($_FILES["imagem"]["name"])) {
        include BASE_DIR . 'Utilitarios' . DS . 'uploadImage.php';
        $usuarioEdita->setImagem($nome_imagem);
    } else {
        $usuarioEdita->setImagem($usuario->getImagem());
    }

    $usuarioController->editar($usuarioEdita);
    $log->log("Editou sua conta de usuario", $usuario);

    $extra = 'app.php?page=usuario';
    header("Location: http://$host$uri/$extra");
}
?>

<div class="row">
    <div class="col-md-8 col-xs-12">
        <form class="form-horizontal" id="formulario" action="app.php?page=usuario&action=edit" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomeCompleto" class="col-sm-4 control-label">Nome Completo</label>
                <div class="col-sm-8">
                    <input type="text" name="nome" value="<?= $usuarioBanco->getNome(); ?>" class="form-control" id="nomeCompleto" placeholder="Nome" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="documento" class="col-sm-4 control-label">CPF</label>
                <div class="col-sm-8">
                    <input type="text" name="documento" value="<?= $usuarioBanco->getDocumento(); ?>" class="form-control" id="documento" placeholder="000.000.000-00">
                </div>
            </div>
            <div class="form-group">
                <label for="telefone" class="col-sm-4 control-label">Telefone</label>
                <div class="col-sm-8">
                    <input type="text" name="telefone" value="<?= $usuarioBanco->getTelefone(); ?>" class="form-control" id="telefone" placeholder="(99) 9 9999-9999">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                    <input type="text" value="<?= $usuarioBanco->getEmail(); ?>" class="form-control" id="email" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label for="senha" class="col-sm-4 control-label">Senha</label>
                <div class="col-sm-8">
                    <input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="senhaDois" class="col-sm-4 control-label">Confirmar Senha</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="senhaDois" placeholder="Confirmar">
                </div>
            </div>
            <div class="form-group">
                <label for="imagemUsuario" class="col-sm-4 control-label">Imagem de capa</label>
                <div class="col-sm-8">
                    <input type="file" id="imagemUsuario" name="imagem">
                    <p class="help-block">Utilize uma imagem 600x600px.</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="button" class="btn btn-success" id="atualiza" onclick="validaCampos()">Atualizar</button>
                    <script type="text/javascript">
                        function validaCampos() {
                            var senha = document.getElementById("senha").value;
                            var confirmaSenha = document.getElementById("senhaDois").value;

                            if (senha === confirmaSenha) {
                                if (senha === '') {
                                    alert("Você deve digitar a sua senha!");
                                } else {
                                    document.getElementById("formulario").submit();
                                }
                            } else {
                                alert("As senhas não conferem!");
                            }
                        }
                    </script>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4 col-xs-12">
        <?php 
        $imgUserBanco = $usuarioBanco->getImagem();
        if (!empty($imgUserBanco) && strcmp($imgUserBanco, "")) {
        ?>
            <img src="imagens/uploads/<?= $usuarioBanco->getImagem() ?>" class="img-responsive img-thumbnail" alt="Minha Foto">
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">Você não cadastrou uma imagem!</div>
        <?php } ?>
    </div>
</div>
<br />