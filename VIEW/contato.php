<?php
require_once BASE_DIR . 'MODEL' . DS . 'Contato.php';
require_once BASE_DIR . 'DAO' . DS . 'ContatoDAO.php';

$contatoDAO = new ContatoDAO();

if (!strcmp(filter_input(INPUT_GET, "action"), "add")) {
    $contato = new Contato();
    $contato->setIdUsuario($usuario->getId_usuario());
    $contato->setTipo(filter_input(INPUT_POST, "tipo"));
    $contato->setMensagem(filter_input(INPUT_POST, "mensagem"));

    $contatoDAO->cadastra($contato);

    $extra = 'app.php?page=contato&msg=Mesagem enviada com sucesso!';
    header("Location: http://$host$uri/$extra");
}
?>
<div class="row">
    <div class="col-md-10">
        <form class="form-horizontal" id="formulario" action="app.php?page=contato&action=add" method="POST">
            <div class="form-group">
                <label class="col-sm-3 control-label">Tipo do Contato</label>
                <div class="col-sm-9">
                    <select class="form-control" name="tipo">
                        <option value="erro">Reportar Erro</option>
                        <option value="melhoria">Sugestão de Melhoria</option>
                        <option value="critica">Critica</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Tipo do Contato</label>
                <div class="col-sm-9">
                    <textarea rows="5" name="mensagem" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Tipo do Contato</label>
                <div class="col-sm-9">
                    <input type="submit" value="Gravar" class="btn btn-success" />
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2">
        <img src="imagens/Phone-Icon.png" alt="Contato" class="img-responsive" />
    </div>
</div>
<?php
$msg = filter_input(INPUT_GET, "msg");
if ($msg != null) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Mensagem enviada com sucesso, em breve retornaremos o seu contato.
            </div>
        </div>
    </div>
    <?php
}