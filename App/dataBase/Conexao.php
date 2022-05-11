<?php

    namespace App\dataBase;

    abstract class Conexao {

        private static $conn;

        public static function getConn() {

            if(self::$conn == null) {

                try {
                    self::$conn = new \PDO('mysql: host=localhost; dbname=gerenciador_estoque;',
                        'root', '');
                } catch (\PDOException $err) {

                    echo 'Erro ao conectar no banco: '.$err->getMessage();
                }
            }

            return self::$conn;
        }
    }