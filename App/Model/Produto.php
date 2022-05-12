<?php

    namespace App\Model;

    use App\dataBase\Conexao;

    class Produto {

        private $id, $nomeProduto, $quantidade, $valorProduto;

        
        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getNomeProduto()
        {
            return $this->nomeProduto;
        }

        public function setNomeProduto($nomeProduto)
        {
            $nomeProduto = strip_tags($nomeProduto);

            if(empty(str_replace(" ", "", $nomeProduto))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $this->nomeProduto = $nomeProduto;
        }

        public function getQuantidade()
        {
            return $this->quantidade;
        }

        public function setQuantidade($quantidade)
        {
            if(empty(str_replace(" ", "", $quantidade))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            if(floor($quantidade) != $quantidade) {
                throw new \Exception("O valor no campo quantidade deve ser do tipo inteiro");
            }

            $this->quantidade = floor($quantidade);
        }

        public function getValorProduto()
        {
            return $this->valorProduto;
        }

        public function setValorProduto($valorProduto)
        {   
            if(empty(str_replace(" ", "", $valorProduto))) {
                throw new \InvalidArgumentException("Existe um ou mais campos inválidos");
            }

            $this->valorProduto = $valorProduto;
        }

        public function buscarPorId($id) {

            $conexao = Conexao::getConn();

            $sql = "SELECT * FROM produto WHERE id = :id";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();

            $resultado = $sql->rowCount();

            $conteudo = $sql->fetchAll();

            if($resultado == 0) {
                throw new \Exception("Esse produto não foi encontrado");
            }

            return $conteudo;
        }

        public function buscarTodosProdutos() {

            $conexao = Conexao::getConn();

            $sql = "SELECT * FROM produto";
            $sql = $conexao->prepare($sql);
            $sql->execute();

            $resultado = $sql->rowCount();

            $retorno = $sql->fetchAll();

            if($resultado == 0) {
                throw new \Exception("Nenhum produto foi encontrado");
            }

            return $retorno;
        }

        public function criarProduto() {

            $conexao = Conexao::getConn();

            $sql = "INSERT INTO produto (nome_produto, quantidade, valor_produto) 
            VALUES (:nome_produto, :quantidade, :valor_produto)";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':nome_produto', $this->getNomeProduto());
            $sql->bindValue(':quantidade', $this->getQuantidade());
            $sql->bindValue(':valor_produto', $this->getValorProduto());
            $resultado = $sql->execute();

            if($resultado = 0) {
                throw new \Exception("Não foi possível criar esse produto");
            }
        }

        public function atualizarProduto() {

            $conexao = Conexao::getConn();

            $sql = "UPDATE produto SET nome_produto = :nome_produto, 
            quantidade = :quantidade, valor_produto = :valor_produto 
            WHERE id = :id";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':id', $this->getId());
            $sql->bindValue(':nome_produto', $this->getNomeProduto());
            $sql->bindValue(':quantidade', $this->getQuantidade());
            $sql->bindValue(':valor_produto', $this->getValorProduto());
            $resultado = $sql->execute();

            if($resultado = 0) {
                throw new \Exception("Não foi possível criar esse produto");
            }
        }

        public function deletarProduto() {

            $conexao = Conexao::getConn();

            $sql = "DELETE FROM produto WHERE id = :id";
            $sql = $conexao->prepare($sql);
            $sql->bindValue(':id', $this->getId());
            $resultado = $sql->execute();

            if($resultado = 0) {
                throw new \Exception("Não foi possível deletar esse produto");
            }
        }
    }