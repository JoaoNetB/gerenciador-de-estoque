<?php

    namespace App\Controller;

    use App\Model\Produto;

    class ProdutoController {

        public function index() {
            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true) {

                $parametros = array();

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('criar.html');

                if(!isset($_SESSION['mensagemErro'])) {

                    $_SESSION['mensagemErro'] = '';
                }
    
                $parametros['mensagemErro'] = $_SESSION['mensagemErro'];

                $conteudo = $template->render($parametros);

                $_SESSION['mensagemErro'] = '';

                echo $conteudo;
            } else {
                header('Location: ?pagina=login');
            }
        }

        public function criar() {

            try {
                $produto = new Produto();
                $produto->setNomeProduto($_POST['nome']);
                $produto->setQuantidade($_POST['quantidade']);
                $produto->setValorProduto($_POST['valor']);

                $produto->criarProduto();

                header('Location: http://localhost/projeto/');
            }catch (\Exception $err) {

                $_SESSION['mensagemErro'] = $err->getMessage();
                header('Location: ?pagina=produto');
            }
        }

        public function editar($params) {

            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true) {

                $parametros = array();

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('editar.html');

                try {
                    $produto = new Produto();
                    $resultado = $produto->buscarPorId($params['id']);
                    $parametros['produto'] = $resultado[0];
    
                }catch (\Exception $err) {
                    $_SESSION['mensagemErro'] = $err->getMessage();
                    header('Location: ?pagina=produto&metodo=editar');
                }

                if(!isset($_SESSION['mensagemErro'])) {

                    $_SESSION['mensagemErro'] = '';
                }
    
                $parametros['mensagemErro'] = $_SESSION['mensagemErro'];

                $conteudo = $template->render($parametros);

                $_SESSION['mensagemErro'] = '';

                echo $conteudo;
            } else {
                header('Location: ?pagina=login');
            }
        }

        public function atualizar() {

            try {
                $produto = new Produto();
                $produto->setId($_POST['id']);
                $produto->setNomeProduto($_POST['nome']);
                $produto->setQuantidade($_POST['quantidade']);
                $produto->setValorProduto($_POST['valor']);
                $produto->atualizarProduto();

                header('Location: http://localhost/projeto/');

            }catch (\Exception $err) {
                $_SESSION['mensagemErro'] = $err->getMessage();
                header('Location: ?pagina=produto&metodo=editar');
            }
        }

        public function deletar($params) {

            try {
                $produto = new Produto();
                $produto->setId($params['id']);
                $produto->deletarProduto();
                header('Location: http://localhost/projeto/');
                
            }catch (\Exception $err) {
                $_SESSION['mensagemErro'] = $err->getMessage();
                header('Location: http://localhost/projeto/');
            }
        }
    }