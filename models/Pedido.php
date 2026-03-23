<?php

class Pedido {
    private $id;
    private $clienteId;
    private $clienteNome;
    private $dataCriacao;
    private $produtos = [];
    private $total;

    public function __construct($id = null, $clienteId = null, $dataCriacao = null) {
        $this->id = $id;
        $this->clienteId = $clienteId;
        $this->dataCriacao = $dataCriacao;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getClienteId() { return $this->clienteId; }
    public function setClienteId($clienteId) { $this->clienteId = $clienteId; }

    public function getClienteNome() { return $this->clienteNome; }
    public function setClienteNome($clienteNome) { $this->clienteNome = $clienteNome; }

    public function getDataCriacao() { return $this->dataCriacao; }
    public function setDataCriacao($dataCriacao) { $this->dataCriacao = $dataCriacao; }

    public function getProdutos() { return $this->produtos; }
    public function setProdutos($produtos) { $this->produtos = $produtos; }

    public function getTotal() { return $this->total; }
    public function setTotal($total) { $this->total = $total; }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->produtos as $produto) {
            $total += $produto->getPreco();
        }
        $this->total = $total;
        return $total;
    }
}
