<?php
require_once BASE_DIR . 'CONTROLLER' . DS . 'PesquisaController.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PerguntaController.php';

require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';

$pesquisaController = new PesquisaController();
$perguntaController = new PerguntaController();

$pergunta = new Pergunta();

$pesquisa = $pesquisaController->busca(filter_input(INPUT_GET, "cod"));
?>
<div class="row">
    <div class="col-md-4 col-sm-4">
        <ul class="list-group">
            <li class="list-group-item"><a href="app.php?page=pesquisa&cod=<?php echo $pesquisa->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar Pesquisa</a></li>
            <li class="list-group-item"><a href="voto.php?chave=<?php echo $pesquisa->getChave(); ?>" target="_blank"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Gerar Link</a></li>
            <li class="list-group-item"><a href="app.php?page=dados&cod=<?php echo $pesquisa->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Dados do Questionário</a></li>
        </ul>
    </div>
    <div class="col-md-8 col-sm-8">
        <h2>Lógica das Perguntas</h2>
        
    </div>
</div>
