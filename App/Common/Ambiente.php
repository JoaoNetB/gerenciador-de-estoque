<?php

    namespace App\Common;

    class Ambiente {

        public static function carregar($dir) {

            if(!file_exists($dir.'/.env')) {
                return false;
            }

            $linhas = file($dir.'/.env');

            foreach($linhas as $linha) {
                putenv(trim($linha));
            }
        }
    }