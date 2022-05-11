<?php

    namespace App\Controller;

    class ErroController {

        public function index() {

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('erro.html');

            $conteudo = $template->render();

            echo $conteudo;
        }
    }