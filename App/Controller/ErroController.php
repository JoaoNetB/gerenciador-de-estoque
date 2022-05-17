<?php

    namespace App\Controller;

    class ErroController {

        public function index() {

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('erro.html');

            $parametros['nomeUrl'] = getenv('NOME_URL');

            $conteudo = $template->render($parametros);

            echo $conteudo;
        }
    }