<?php

    namespace App\Controller;

    use App\Model\Usuario;

    class LoginController {

        public function index() {

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('login.html');

            if(!isset($_SESSION['mensagemErro'])) {

                $_SESSION['mensagemErro'] = '';
            }

            $parametros['mensagemErro'] = $_SESSION['mensagemErro'];

            $conteudo = $template->render($parametros);

            $_SESSION['mensagemErro'] = '';

            echo $conteudo;
        }

        public function entrar() {

            $usuario = new Usuario();

            try {
                $usuario->buscarLogin($_POST['email'], $_POST['senha']);

                header('Location: http://localhost/projeto/');
            } catch (\Exception $err) {

                $_SESSION['mensagemErro'] = $err->getMessage();

                header('Location: ?pagina=login');
            }
        }

        public function sair() {

            session_destroy();
            header('Location: http://localhost/projeto/');
        }
    }