<?php

    namespace App\Controller;

    use App\Model\Usuario;

    class ContribuidorController {

        public function index() {
            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true 
            && $_SESSION['cargoGerenciador'] == 'admin') {

                $parametros = array();

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('contribuidor.html');

                try {

                    $usuario = new Usuario();
                    $parametros['usuarios'] = $usuario->buscarTodosUsuarios();

                } catch (\Exception $err) {
                    $_SESSION['mensagemErro'] = $err->getMessage();
                    $parametros['usuarios']['id'] = '';
                    $parametros['usuarios']['nome'] = '';
                    $parametros['usuarios']['email'] = '';
                    $parametros['usuarios']['senha'] = '';
                    $parametros['usuarios']['cargo'] = '';
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
    }