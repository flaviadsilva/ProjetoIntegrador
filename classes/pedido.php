<?php

class Pedido {
    private $numero;
    private $cliente;
    private $produtos = [];

    public function __construct($numero, $cliente) {
        $this->numero = $numero;
        $this->cliente = $cliente;
    }

    public function adicionarProduto($produto) {
        $this->produtos[] = $produto;
    }

    public function calcularTotal() {
        $total = 0;

        foreach ($this->produtos as $produto) {
            $total += $produto->getPreco();
        }

        return $total;
    }

    public function exibirResumo() {
        echo "<div class='container'>";
        
        echo "<h2>Pedido Nº {$this->numero}</h2>";

        echo "<h3>Cliente:</h3>";
        echo "<p>{$this->cliente->getNome()}<br>";
        echo "{$this->cliente->getEmail()}</p>";

        echo "<h3>Produtos:</h3><ul>";

        foreach ($this->produtos as $produto) {
            echo "<li>";
            echo $produto->getNome() . " - R$ " . number_format($produto->getPreco(), 2, ',', '.');
            echo "</li>";
        }

        echo "</ul>";

        echo "<h3 class='total'>Total: R$ " . number_format($this->calcularTotal(), 2, ',', '.') . "</h3>";

        echo "</div>";
    }
}