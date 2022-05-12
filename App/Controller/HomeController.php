<?php

    namespace App\Controller;

    use App\Model\Produto;

    class HomeController {

        public function index() {

            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true) {

                $parametros = array();

                if(isset($_SESSION['nomeGerenciador'])) {
                    $parametros['nome'] = $_SESSION['nomeGerenciador'];
                } else {
                    $parametros['nome'] = '';
                }

                try{
                    $produto = new Produto();
                    $parametros['produtos'] = $produto->buscarTodosProdutos();

                } catch (\Exception $err) {
                    $_SESSION['mensagemErro'] = $err->getMessage();
                    $parametros['produto']['id'] = '-';
                    $parametros['produto']['nome_produto'] = '-';
                    $parametros['produto']['quantidade'] = '-';
                    $parametros['produto']['valor_produto'] = '-';
                }

                if(!isset($_SESSION['mensagemErro'])) {

                    $_SESSION['mensagemErro'] = '';
                }
    
                $parametros['mensagemErro'] = $_SESSION['mensagemErro'];

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('home.html');

                $conteudo = $template->render($parametros);

                $_SESSION['mensagemErro'] = '';

                echo $conteudo;
            } else {
                header('Location: ?pagina=login');
            }
        }
    }