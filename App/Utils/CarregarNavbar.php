<?php

    namespace App\Utils;

    class CarregarNavbar {

        public function carregar() {

            if(!isset($_GET['pagina']) || $_GET['pagina'] == 'home') {

                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('navbar.html');
    
                $parametros = array();
                
                if(isset($_SESSION['loginGerenciador']) 
                && isset($_SESSION['cargoGerenciador']) 
                && $_SESSION['nomeGerenciador']) {

                    $parametros['login'] = $_SESSION['loginGerenciador'];
                    $parametros['cargo'] = $_SESSION['cargoGerenciador'];
                    $parametros['nome'] = $_SESSION['nomeGerenciador'];
                }

                $conteudo = $template->render($parametros);
    
                echo $conteudo;
            }

        }
    }