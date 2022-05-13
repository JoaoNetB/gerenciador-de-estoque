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
            if(empty(str_replace(" ", "", $id))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $this->id = $id;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function setNome($nome)
        {
            if(empty(str_replace(" ", "", $nome))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }
            $this->nome = $nome;

        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            if(empty(str_replace(" ", "", $email))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $this->email = $email;
        }

        public function getSenha()
        {
            return $this->senha;
        }

        public function setSenha($senha)
        {
            if(empty(str_replace(" ", "", $senha))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        }

        public function getCargo()
        {
            return $this->cargo;
        }

        public function setCargo($cargo)
        {   
            if(empty(str_replace(" ", "", $cargo))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

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

        public function buscarTodosUsuarios() {

            $conexao = Conexao::getConn();

            $sql = "SELECT * FROM usuario";
            $sql = $conexao->prepare($sql);
            $sql->execute();

            $resultado = $sql->rowCount();
            $conteudo = $sql->fetchAll();

            if($resultado == 0) {
                throw new \Exception("Nenhum usuario foi encontrado");
            }

            return $conteudo;
        }

        public function criarUsuario() {

            $conexao = Conexao::getConn();

            $sql = "INSERT INTO usuario (nome, email, senha, cargo) VALUES (:nome, :email, :senha, :cargo)";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':nome', $this->getNome());
            $sql->bindValue(':email', $this->getEmail());
            $sql->bindValue(':senha', $this->getSenha());
            $sql->bindValue(':cargo', $this->getCargo());
            $sql->execute();

            $resultado = $sql->rowCount();

            if($resultado == 0) {
                throw new \Exception("Não foi possível criar esse usuário");
            }
        }
    }