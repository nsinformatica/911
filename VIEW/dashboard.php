<?php

require_once BASE_DIR . 'DAO' . DS . 'VotoDAO.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PesquisaController.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PerguntaController.php';
require_once BASE_DIR . 'Utilitarios' . DS . 'LogUtil.php';

$pesquisaController = new PesquisaController();
$perguntaController = new PerguntaController();
$votoDAO = new VotoDAO();
$pesquisa = new Pesquisa();
$log = new LogUtil();

if (!strcmp(filter_input(INPUT_GET, "action"), "cadPesquisa")) {
    
    $pesquisa->setTitulo(filter_input(INPUT_POST, "descPesquisa"));
    $pesquisa->setStatus("1");
    $pesquisa->setPublicada("1");
    $pesquisaController->cadastrar($pesquisa, $usuario);
    
    $log->log("Cadastrou nova pesquisa", $usuario);
    
    $extra = 'app.php';
    header("Location: http://$host$uri/$extra");
} else if (!strcmp(filter_input(INPUT_GET, "action"), "delete")) {
    $pesquisaController->status(0, filter_input(INPUT_GET, "cod"));
    
    $log->log("Apagou pesquisa com ID: " . filter_input(INPUT_GET, "cod"), $usuario);
    
    $extra = 'app.php';
    header("Location: http://$host$uri/$extra");
} else if (!strcmp(filter_input(INPUT_GET, "action"), "stop")) {
    $pesquisaController->publicada(0, filter_input(INPUT_GET, "cod"));
    
    $log->log("Encerrou pesquisa com ID: " . filter_input(INPUT_GET, "cod"), $usuario);
    
    $extra = 'app.php';
    header("Location: http://$host$uri/$extra");
}
?>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalPesquisa">
            Criar Pesquisa
        </button>
    </div>
</div>

<br />
<?php
    if ($pesquisaController->isPesquisa($usuario)) {
?>
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-success">
                <div class="panel-heading">TOTAL DE RESPOSTAS</div>
                <div class="panel-body">
                    <p><?php
                       $contaVotos = 0;
                       foreach ($pesquisaController->lista($usuario, 0, 100) as $vt) {
                           $contaVotos = $contaVotos + $vt->getContador();
                       }
                       echo $contaVotos;
                    ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-danger">
                <div class="panel-heading">TOTAL DE PESQUISAS</div>
                <div class="panel-body">
                    <p><?php echo $pesquisaController->contaPesquisas($usuario); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-info">
                <div class="panel-heading">TOTAL DE PERGUNTAS</div>
                <div class="panel-body">
                    <p><?php echo $perguntaController->contaPerguntas($usuario->getId_usuario()); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table border="0" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-1 col-sm-1">#</th>
                        <th class="col-md-8 col-sm-8">Minhas Pesquisas</th>
                        <th class="col-md-3 col-sm-3">Funções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pesquisaController->lista($usuario, 0, 5) as $pesquisaBanco) { ?>
                    <tr>
                        <td><?php echo $pesquisaBanco->getId_pesquisa(); ?></td>
                        <td><?php echo $pesquisaBanco->getTitulo(); ?></td>
                        <td>
                            <a title="Editar Pesquisa" href="app.php?page=pesquisa&cod=<?php echo $pesquisaBanco->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> &nbsp;
                            <a title="Gerar Link" target="_blank" href="voto.php?chave=<?php echo $pesquisaBanco->getChave(); ?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a> &nbsp;
                            <a title="Dados da pesquisa" href="app.php?page=dados&cod=<?php echo $pesquisaBanco->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a> &nbsp;
                            <a title="Encerrar Pesquisa" id="linkEncerra" onclick="if(confirm('Você realmente deseja encerrar essa persquisa?')){window.location.assign('app.php?page=dashboard&action=stop&cod=<?php echo $pesquisaBanco->getId_pesquisa(); ?>');}"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>&nbsp;
                            <a title="Excluir Pesquisa" id="linkExcluir" onclick="if(confirm('Você realmente deseja excluir essa persquisa?')){window.location.assign('app.php?page=dashboard&action=delete&cod=<?php echo $pesquisaBanco->getId_pesquisa(); ?>');}"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a> &nbsp;&nbsp<?= $pesquisaBanco->getContador(); ?> Respostas
                            <script>document.getElementById("linkExcluir").style.cursor = "pointer";</script>
                            <script>document.getElementById("linkEncerra").style.cursor = "pointer";</script>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning" role="alert"><p>Você não tem pesquisas, utilize o botão criar pesquisa logo acima!</p></div>
<?php } ?>
<div class="modal fade" id="modalPesquisa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nova Pesquisa</h4>
            </div>
            <div class="modal-body">
                <form action="app.php?page=dashboard&action=cadPesquisa" method="POST">
                    <div class="input-group">
                        <input type="text" name="descPesquisa" class="form-control" placeholder="Nome da Pesquisa" required="">
                        <span class="input-group-btn">
                            <input type="submit" value="Cadastrar" class="btn btn-default "/>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
