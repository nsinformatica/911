<?php
$host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$uri = rtrim(dirname(filter_input(INPUT_SERVER, 'PHP_SELF')), '/\\');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

include_once './DAO/VotoDAO.php';
include_once './DAO/Itens_perguntaDAO.php';
include_once './MODEL/Voto.php';
include_once './MODEL/Pesquisa.php';
include_once './MODEL/Pergunta.php';
include_once './Utilitarios/ResolveItem.php';
include_once './CONTROLLER/PerguntaController.php';
include_once './CONTROLLER/PesquisaController.php';

$perguntaController = new PerguntaController();
$pesquisaControler = new PesquisaController();

$voto = new Voto();
$votoDAO = new VotoDAO();

$id_pesquisa = filter_input(INPUT_GET, "chave");

$pesquisa = $pesquisaControler->busca($pesquisaControler->buscarPorChave($id_pesquisa));
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $pesquisa->getTitulo(); ?> - BoxVoto</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/estilo_voto.css" rel="stylesheet">
        <link href="css/star-rating.min.css" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <link rel="icon" href="imagens/icon.ico" />

        <link href="https://fonts.googleapis.com/css?family=Patua+One|Raleway" rel="stylesheet"> 

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <meta property="og:title" content="<?php echo $pesquisa->getTitulo(); ?>">
        <meta property="og:image" content="<?php echo 'imagens/uploads/' . $pesquisa->getImagem() ?>">
        <meta property="og:image:type" content="image/jpeg">
    </head>
    <body>
        <div class="container">
            <div class="well"><img alt="Logo VotoBox" src="imagens/logo.png" class="" style="max-height: 50px;" /></div>
            <?php
            if ($pesquisa->getPublicada() == 1) {
                $imgPesqImg = $pesquisa->getImagem();
                if (!empty($imgPesqImg)) {
                    ?>
                    <div class="row">
                        <div class="col-md-12 cab">
                            <img src="imagens/uploads/<?= $pesquisa->getImagem(); ?>" class="img-responsive img-thumbnail" alt="Minha Foto">
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12 titulo">
                        <h1><?php echo $pesquisa->getTitulo(); ?></h1>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12 descricao">
                        <?php echo $pesquisa->getDescricao(); ?>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <form action="cadVoto.php?action=gravar&codPesquisa=<?php echo $pesquisa->getId_pesquisa(); ?>" method="POST">
                            <?php foreach ($perguntaController->lista($pesquisa, 0, 100) as $pergunta) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b><?php echo $pergunta->getPergunta(); ?></b>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                $intemPergunta = new Itens_perguntaDAO();
                                                $listaDeItens = $intemPergunta->lista($pergunta, 0, 20);
                                                $resolveItem = new ResolveItem($listaDeItens);
                                                $resolveItem->resolve($pergunta->getTipo(), $pergunta->getId_pergunta(), $pergunta->getObrigatorio());
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="g-recaptcha" data-sitekey=""></div>
                            <br />
                            <input type="submit" value="Salvar" class="btn btn-success" />
                        </form>
                        <br />
                        <br />
                        <br />
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Esta pesquisa ainda não foi publicada, por favor entre em contato com o Administrador.
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/star-rating.min.js"></script>
        <script src="js/locales/pt-BR.js"></script>
        <script>
            $(".rankStar").rating({min:0, max:5, step:1, size:'md', language:'pt-BR'});
        </script>
    </body>
</html>
