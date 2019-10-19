<?php
require_once BASE_DIR . 'DAO' . DS . 'Itens_perguntaDAO.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
require_once BASE_DIR . 'MODEL' . DS . 'Itens_pergunta.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PesquisaController.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PerguntaController.php';
require_once BASE_DIR . 'Utilitarios' . DS . 'ResolveItem.php';
require_once BASE_DIR . 'Utilitarios' . DS . 'LogUtil.php';

$pesquisaController = new PesquisaController();
$perguntaController = new PerguntaController();

$pergunta = new Pergunta();
$log = new LogUtil();

$pesquisa = $pesquisaController->busca(filter_input(INPUT_GET, "cod"));

if (!strcmp(filter_input(INPUT_GET, "action"), "edit")) {

    $pesquisaEdita = new Pesquisa();
    $pesquisaEdita->setId_pesquisa($pesquisa->getId_pesquisa());
    $pesquisaEdita->setTitulo(filter_input(INPUT_POST, "titulo"));
    $pesquisaEdita->setDescricao(filter_input(INPUT_POST, "descricao"));

    if (!empty($_FILES["imagem"]["name"])) {
        include BASE_DIR . 'Utilitarios' . DS . 'uploadImage.php';
        $pesquisaEdita->setImagem($nome_imagem);
    } else {
        $pesquisaEdita->setImagem($pesquisa->getImagem());
    }
    
    $pesquisaEdita->setStatus("1");
    $pesquisaController->edita($pesquisaEdita);
    
    $log->log("Editou pesquisa com ID: " . $pesquisa->getId_pesquisa(), $usuario);
    
    $extra = 'app.php?page=pesquisa&cod=' . $pesquisa->getId_pesquisa();
    header("Location: http://$host$uri/$extra");
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "addPergunta")) {
    $pergunta->setPergunta(filter_input(INPUT_POST, "perguntaTexto"));
    $pergunta->setTipo(filter_input(INPUT_POST, "tipoPergunta"));
    $pergunta->setObrigatorio(filter_input(INPUT_POST, "obrigatorio"));
    $pergunta->setPesquisa($pesquisa->getId_pesquisa());

    $perguntaController->cadastra($pergunta);
    $log->log("Editou pesquisa com ID: " . $pesquisa->getId_pesquisa(), $usuario);

    $extra = 'app.php?page=pesquisa&cod=' . $pesquisa->getId_pesquisa();
    header("Location: http://$host$uri/$extra");
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "addItem")) {
    $itemPergunta = new Itens_pergunta();
    $itemPerguntaDAO = new Itens_perguntaDAO();
    $itemPergunta->setPergunta(filter_input(INPUT_GET, "codPegunta"));
    $itemPergunta->setDescricao(filter_input(INPUT_POST, "descItem"));
    $itemPergunta->setNumero($itemPerguntaDAO->contaItens(filter_input(INPUT_POST, "codP")) + 1);

    if (!empty($_FILES["imagem"]["name"])) {
        include BASE_DIR . 'Utilitarios' . DS . 'uploadImage.php';
        $itemPergunta->setImagem($nome_imagem);
    } else {
        $itemPergunta->setImagem("");
    }
    $itemPerguntaDAO->cadastra($itemPergunta);
    
    $log->log("Edicionou item a pergunta ID: " . filter_input(INPUT_GET, "codPegunta"), $usuario);

    $extra = 'app.php?page=pesquisa&cod=' . filter_input(INPUT_POST, "cod");
    header("Location: http://$host$uri/$extra");
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "delItem")) {
    $itemPerguntaDAO = new Itens_perguntaDAO();
    $itemPerguntaDAO->excluir(filter_input(INPUT_POST, "codPegunta"));

    $log->log("Apagou item da pergunta ID: " . filter_input(INPUT_GET, "codPegunta"), $usuario);
    
    $extra = 'app.php?page=pesquisa&cod=' . filter_input(INPUT_POST, "cod");
    header("Location: http://$host$uri/$extra");
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "editPergunta")) {
    $pergunta->setPergunta(filter_input(INPUT_POST, "perguntaTexto"));
    $pergunta->setTipo(filter_input(INPUT_POST, "tipoPergunta"));
    $pergunta->setObrigatorio(filter_input(INPUT_POST, "obrigatorio"));
    $pergunta->setId_pergunta(filter_input(INPUT_GET, "cod"));

    $perguntaController->edita($pergunta);
    $log->log("Editou pergunta ID: " . filter_input(INPUT_GET, "cod"), $usuario);

    $extra = 'app.php?page=pesquisa&cod=' . filter_input(INPUT_POST, "codPesquisa");
    header("Location: http://$host$uri/$extra");
} elseif (!strcmp(filter_input(INPUT_GET, "action"), "delPergunta")) {

    $perguntaController->excluir(filter_input(INPUT_GET, "cod"));

    $log->log("Apagou pergunta ID: " . filter_input(INPUT_GET, "cod"), $usuario);
    
    $extra = 'app.php?page=pesquisa&cod=' . filter_input(INPUT_POST, "codPesquisa");
    header("Location: http://$host$uri/$extra");
}
?>

<div class="row">
    <div class="col-md-4 col-sm-4">
        <ul class="list-group">
            <li class="list-group-item"><a href="voto.php?chave=<?php echo $pesquisa->getChave(); ?>" target="_blank"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Gerar Link</a></li>
            <li class="list-group-item"><a href="app.php?page=dados&cod=<?php echo $pesquisa->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Dados do Questionário</a></li>
            <!--<li class="list-group-item"><a href="app.php?page=logica&cod=<?php echo $pesquisa->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> Lógica das Perguntas</a></li>-->
        </ul>
    </div>
    <div class="col-md-8 col-sm-8">
        <h2>Edite o seu questionário</h2>
        <form action="app.php?page=pesquisa&action=edit&cod=<?php echo filter_input(INPUT_GET, "cod"); ?>" method="POST" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="etitulo">Titulo</label>
                        <input type="text" value="<?php echo $pesquisa->getTitulo(); ?>" class="form-control" id="etitulo" name="titulo" required="">
                    </div>
                    <textarea class="" rows="3" id="descr" name="descricao"><?php echo $pesquisa->getDescricao(); ?></textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace('descr');
                    </script>
                    <br />
                    <div class="form-group">
                        <label for="imagem">Imagem de capa</label>
                        <input type="file" id="imagem" name="imagem">
                        <p class="help-block">Utilize uma imagem 300x1900px.</p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <input type="submit" name="salvar" value="Salvar Alterações" class="btn btn-success" />
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPesquisa"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>  Criar Pergunta</button>
                </div>
            </div>
        </form>
        <hr />
        <?php foreach ($perguntaController->lista($pesquisa, 0, 100) as $pergunta) { ?>
            <div class = "panel panel-default">
                <div class = "panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><b><?php echo $pergunta->getPergunta(); ?></b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $intemPergunta = new Itens_perguntaDAO();
                            $listaDeItens = $intemPergunta->lista($pergunta, 0, 20);
                            $resolveItem = new ResolveItem($listaDeItens);
                            $resolveItem->resolve($pergunta->getTipo(), $pergunta->getId_pergunta(), 0);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                            <?php if ($pergunta->getTipo() != 3 and $pergunta->getTipo() != 4) { ?>
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-add-<?php echo $pergunta->getId_pergunta(); ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Adicionar Item</button>
                                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-del-<?php echo $pergunta->getId_pergunta(); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Apagar Item</button>
                                </div>
                            <?php } ?>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target=".bs-example-modal-sm-editP-<?php echo $pergunta->getId_pergunta(); ?>"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Editar Pergunta</button>
                                <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm-delP-<?php echo $pergunta->getId_pergunta(); ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Apagar Pergunta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm-add-<?php echo $pergunta->getId_pergunta(); ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Adicionar Item</h4>
                        </div>
                        <div class="modal-body">
                            <form action="app.php?page=pesquisa&action=addItem&codPegunta=<?php echo $pergunta->getId_pergunta(); ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="descItem">Descrição</label>
                                    <input type="text" value="" class="form-control" id="descItem" name="descItem" required="">
                                </div>
                                <br />
                                <div class="form-group">
                                    <label for="imagemItem">Imagem de capa</label>
                                    <input type="file" id="imagemItem" name="imagem">
                                    <p class="help-block">Utilize uma imagem 400x400px.</p>
                                </div>
                                <hr />
                                <input type="hidden" name="codP" value="<?php echo $pergunta->getId_pergunta(); ?>" />
                                <input type="hidden" name="cod" value="<?php echo $pesquisa->getId_pesquisa(); ?>" />
                                <input type="submit" class="btn btn-primary btn-sm" value="Gravar" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm-del-<?php echo $pergunta->getId_pergunta(); ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Deletar Item</h4>
                        </div>
                        <div class="modal-body">
                            <form action="app.php?page=pesquisa&action=delItem" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="etitulo">Descrição</label>
                                    <select class="form-control" name="codPegunta">
                                        <?php foreach ($listaDeItens as $item) { ?>
                                            <option value="<?php echo $item->getId_itens_pergunta(); ?>"><?php echo $item->getDescricao(); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <hr />
                                <input type="hidden" name="cod" value="<?php echo $pesquisa->getId_pesquisa(); ?>" />
                                <input type="submit" class="btn btn-primary btn-sm" value="Apagar" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm-editP-<?php echo $pergunta->getId_pergunta(); ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar Pergunta</h4>
                        </div>
                        <div class="modal-body">
                            <form action="app.php?page=pesquisa&action=editPergunta&cod=<?php echo $pergunta->getId_pergunta(); ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="perguntaTexto">Pergunta</label>
                                            <input type="text" value="<?php echo $pergunta->getPergunta(); ?>" name="perguntaTexto" class="form-control" id="perguntaTexto" placeholder="Descreva sua Pergunta" required="">
                                        </div>
                                        <br />
                                        <br />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="radio" name="tipoPergunta" id="" value="1" <?php
                                        if ($pergunta->getTipo() == 1) {
                                            echo 'checked=""';
                                        }
                                        ?> />
                                        <img src="imagens/escolha_unica.jpeg" alt="" title="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="tipoPergunta" id="" value="3"<?php
                                        if ($pergunta->getTipo() == 3) {
                                            echo 'checked=""';
                                        }
                                        ?> />
                                        <img src="imagens/texto_simples.jpeg" alt="" title="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="tipoPergunta" id="" value="4"<?php
                                        if ($pergunta->getTipo() == 4) {
                                            echo 'checked=""';
                                        }
                                        ?> />
                                        <img src="imagens/escolha_escala.jpeg" alt="" title="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="tipoPergunta" id="" value="5"<?php
                                        if ($pergunta->getTipo() == 5) {
                                            echo 'checked=""';
                                        }
                                        ?> />
                                        <img src="imagens/escolha_imagem.jpeg" alt="" title="" />
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Esta Pergunta será obrigatória?</p>
                                        <label class="radio-inline">
                                            <input type="radio" name="obrigatorio" id="" value="1" <?php
                                            if ($pergunta->getObrigatorio() == 1) {
                                                echo 'checked=""';
                                            }
                                            ?> /> Sim
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="obrigatorio" id="" value="0" <?php
                                            if ($pergunta->getObrigatorio() == 1) {
                                                echo 'checked=""';
                                            }
                                            ?> /> Não
                                        </label>
                                    </div>
                                </div>
                                <hr />
                                <input type="hidden" name="codPesquisa" value="<?php echo $pesquisa->getId_pesquisa(); ?>" />
                                <input type="submit" value="Gravar" class="btn btn-success" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm-delP-<?php echo $pergunta->getId_pergunta(); ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Excluir Pergunta</h4>
                        </div>
                        <div class="modal-body">
                            <form action="app.php?page=pesquisa&action=delPergunta&cod=<?php echo $pergunta->getId_pergunta(); ?>" method="POST">
                                <div class="row">
                                    <input type="hidden" name="codPesquisa" value="<?php echo $pesquisa->getId_pesquisa(); ?>" />
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success btn-block" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                        <input type="submit" value="Excluir" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="modal fade" id="modalPesquisa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nova Pergunta</h4>
            </div>
            <div class="modal-body">
                <form action="app.php?page=pesquisa&action=addPergunta&cod=<?php echo filter_input(INPUT_GET, "cod"); ?>" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="perguntaTexto">Pergunta</label>
                                <input type="text" name="perguntaTexto" class="form-control" id="perguntaTexto" placeholder="Descreva sua Pergunta" required="">
                            </div>
                            <br />
                            <br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="radio" name="tipoPergunta" id="" value="1" checked="">
                            <img src="imagens/escolha_unica.jpeg" alt="" title="" />
                        </div>
                        <div class="col-md-4">
                            <input type="radio" name="tipoPergunta" id="" value="3">
                            <img src="imagens/texto_simples.jpeg" alt="" title="" />
                        </div>
                        <div class="col-md-4">
                            <input type="radio" name="tipoPergunta" id="" value="4">
                            <img src="imagens/escolha_escala.jpeg" alt="" title="" />
                        </div>
                        <div class="col-md-4">
                            <input type="radio" name="tipoPergunta" id="" value="5">
                            <img src="imagens/escolha_imagem.jpeg" alt="" title="" />
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <p>Esta Pergunta será obrigatória?</p>
                            <label class="radio-inline">
                                <input type="radio" name="obrigatorio" id="inlineRadio1" value="1"> Sim
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="obrigatorio" id="inlineRadio2" value="0"> Não
                            </label>
                        </div>
                    </div>
                    <hr />
                    <input type="submit" value="Gravar" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
</div>