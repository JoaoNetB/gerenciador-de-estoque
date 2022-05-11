<?php

    namespace App\Controller;

    class HomeController {

        public function index() {

            if(isset($_SESSION['loginGerenciador']) && $_SESSION['loginGerenciador'] == true) {

                $loader = new \Twig\Loader\FilesystemLoader('App/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('home.html');

                $conteudo = $template->render();

                echo $conteudo;
            } else {
                header('Location: ?pagina=login');
            }
        }
    }