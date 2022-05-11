<?php

    namespace App\Model;

    use App\dataBase\Conexao;

    class Usuario {

        private $id, $nome, $email, $senha, $cargo;

        public function getId()
        {
             return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;

        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getSenha()
        {
            return $this->senha;
        }

        public function setSenha($senha)
        {
            $this->senha = $senha;
        }

        public function getCargo()
        {
            return $this->cargo;
        }

        public function setCargo($cargo)
        {
            $this->cargo = $cargo;
        }

        public function buscarLogin($email, $senha) {

            if(empty(str_replace(" ", "", $email)) || empty(str_replace(" ", "", $senha))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $conexao = Conexao::getConn();

            $sql = "SELECT * FROM usuario WHERE email = :email";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':email', $email);
            $sql->execute();

            $resultado = $sql->rowCount();

            $retorno = $sql->fetchAll();
            
            if($resultado == 0) {
                throw new \Exception("Esse usuario não foi encontrado");
            }

            if(!password_verify($senha, $retorno[0]['senha'])) {
                throw new \Exception("Senha incorreta");
            }

            $_SESSION['loginGerenciador'] = true;
            $_SESSION['cargoGerenciador'] = $retorno[0]['cargo'];
            $_SESSION['nomeGerenciador'] = $retorno[0]['nome'];
        }
    }