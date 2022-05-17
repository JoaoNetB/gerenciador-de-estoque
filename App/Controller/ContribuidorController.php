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
                $parametros['nomeUrl'] = getenv('NOME_URL');

                $conteudo = $template->render($parametros);

                $_SESSION['mensagemErro'] = '';

                echo $conteudo;
            } else {
                header('Location: ?pagina=login');
            }
        }

        public function criar() {
            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true 
            && $_SESSION['cargoGerenciador'] == 'admin') {

                $parametros = array();

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('criarUsuario.html');

                $parametros['mensagemErro'] = $_SESSION['mensagemErro'];
                $parametros['nomeUrl'] = getenv('NOME_URL');

                $conteudo = $template->render($parametros);

                $_SESSION['mensagemErro'] = '';

                echo $conteudo;
            } else {

                header('Location: ?pagina=login');
            }
        }

        public function adicionar() {
            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true 
            && $_SESSION['cargoGerenciador'] == 'admin') {

                try {
                    $usuario = new Usuario();
                    $usuario->setNome($_POST['nome']);
                    $usuario->setEmail($_POST['email']);
                    $usuario->setSenha($_POST['senha']);
                    $usuario->setCargo($_POST['cargo']);
                    $usuario->criarUsuario();

                    header('Location: ?pagina=contribuidor');
                } catch (\Exception $err) {

                    $_SESSION['mensagemErro'] = $err->getMessage();
                    header('Location: ?pagina=contribuidor&metodo=criar');
                }
            }else {

                header('Location: ?pagina=login');
            }
        }

        public function editar($params) {
            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true 
            && $_SESSION['cargoGerenciador'] == 'admin') {

                try {
                    $usuario = new Usuario();

                }catch (\Exception $err) {
                    $_SESSION['mensagemErro'] = $err->getMessage();
                    header('Location: ?pagina=contribuidor&metodo=editar');
                }

            }else {

                header('Location: ?pagina=login');
            }
        }
    }