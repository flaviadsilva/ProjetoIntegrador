<?php

class Produto {
    private $id;
    private $nome;
    private $preco;

    public function __construct($id, $nome, $preco) {
        $this->setId($id);
        $this->setNome($nome);
        $this->setPreco($preco);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        if ($preco < 0) {
            echo "Preço inválido!";
            return;
        }
        $this->preco = $preco;
    }
}