<?php
require_once BASE_DIR . 'DAO' . DS . 'Itens_perguntaDAO.php';
require_once BASE_DIR . 'DAO' . DS . 'VotoDAO.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pesquisa.php';
require_once BASE_DIR . 'MODEL' . DS . 'Pergunta.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PesquisaController.php';
require_once BASE_DIR . 'CONTROLLER' . DS . 'PerguntaController.php';

$perguntaController = new PerguntaController();
$pesquisaController = new PesquisaController();

$pesquisa =$pesquisaController->busca(filter_input(INPUT_GET, "cod"));

$itensPergunta = new Itens_perguntaDAO();
$votoDAO = new VotoDAO();
?>
<div class="row">
    <div class="col-md-4 col-sm-4">
        <ul class="list-group">
            <li class="list-group-item"><a href="app.php?page=pesquisa&cod=<?php echo $pesquisa->getId_pesquisa(); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar Pesquisa</a></li>
            <li class="list-group-item"><a href="voto.php?chave=<?php echo $pesquisa->getChave(); ?>" target="_blank"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Gerar Link</a></li>
        </ul>
    </div>
    <div class="col-md-8 col-sm-8">
        <h2>Dados o seu questionário</h2>
        <?php foreach ($perguntaController->lista($pesquisa, 0, 100) as $perguntaBanco) { ?>
            <?php if ($perguntaBanco->getTipo() == 1) { ?>
                <table border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $perguntaBanco->getPergunta(); ?></th>
                        </tr>
                        <tr>
                            <th>Item da Pesquisa</th>
                            <th>Total de Votos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($itensPergunta->lista($perguntaBanco, 0, 10000) as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item->getDescricao(); ?></td>   
                                <td><?php echo $votoDAO->contaVoto($perguntaBanco->getId_pergunta(), $item->getId_itens_pergunta()); ?></td>   
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($perguntaBanco->getTipo() == 3) { ?>
                <table border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $perguntaBanco->getPergunta(); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contTexto = 0;
                        foreach ($votoDAO->listaPorPergunta($perguntaBanco->getId_pergunta()) as $item) {
                            $p = $item->getTexto();
                            if (strlen($p) > 0) {
                                ?>
                                <tr>
                                    <td><?php echo $p; ?></td>   
                                </tr>
                                <?php
                                $contTexto++;
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($perguntaBanco->getTipo() == 4) { ?>
                <table border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $perguntaBanco->getPergunta(); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contEscala = 0;
                        $somaEscala = 0;
                        foreach ($votoDAO->listaPorPergunta($perguntaBanco->getId_pergunta()) as $item) {
                            $somaEscala = $somaEscala + $votoDAO->listaPorPergunta($perguntaBanco->getId_pergunta())[$contEscala]->getEscala();
                            $contEscala++;
                        }
                        ?>
                        <tr>
                            <td><?php echo "A média das respostas é: <b>" . number_format($somaEscala / $contEscala, 2, ',', ' ') . "</b>"; ?></td>   
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($perguntaBanco->getTipo() == 5) { ?>
                <table border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $perguntaBanco->getPergunta(); ?></th>
                        </tr>
                        <tr>
                            <th>Item da Pesquisa</th>
                            <th>Total de Votos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($itensPergunta->lista($perguntaBanco, 0, 10000) as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item->getDescricao(); ?></td>   
                                <td><?php echo $votoDAO->contaVoto($perguntaBanco->getId_pergunta(), $item->getId_itens_pergunta()); ?></td>   
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        
        <?php } ?>
        
        <div class="alert alert-info" role="alert">Esta pesquisa recebeu <strong><?= $pesquisa->getContador() ?></strong> votos.</div>
        
    </div>
</div>