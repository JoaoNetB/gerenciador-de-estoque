<?php

    namespace App\Core;

    class Core {

        private $acao;
        private $controller;

        public function start($url) {
            
            if(isset($url['pagina']) && !empty($url['pagina'])) {

                $this->controller = ucfirst($url['pagina'].'Controller');
            } else {
                $this->controller = 'HomeController';
            }

            $this->controller = "App\Controller\ $this->controller";
            $this->controller = str_replace(" ", "", $this->controller);

            if(isset($url['metodo'])) {
                $this->acao = $url['metodo'];
            }else {
                $this->acao = 'index';
            }

            if(!class_exists($this->controller)) {

                $this->controller = 'ErroController';

                $this->controller = "App\Controller\ $this->controller";
                $this->controller = str_replace(" ", "", $this->controller);

            }


            call_user_func_array(array(new $this->controller, $this->acao), array($url) ?? null);
        }
    }   