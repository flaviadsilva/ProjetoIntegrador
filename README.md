# ProjetoIntegrador
# 🛒 Sistema de Pedidos em PHP

---

## 📌 Sobre o Projeto

Este projeto foi desenvolvido com o objetivo de aplicar conceitos de **Programação Orientada a Objetos (POO) em PHP**, juntamente com **HTML, CSS e organização de código**.

O sistema simula o funcionamento básico de uma loja, permitindo o gerenciamento de:

* 👤 Clientes
* 📦 Produtos
* 🧾 Pedidos

---

## 🎯 Funcionalidades

✔ Cadastro de clientes
✔ Cadastro de produtos
✔ Criação de pedidos
✔ Adição de múltiplos produtos ao pedido
✔ Cálculo automático do total
✔ Exibição de pedidos organizados
✔ Navegação entre páginas
✔ Layout moderno e responsivo

---

## 🧠 Conceitos Aplicados

* Programação Orientada a Objetos (POO)
* Encapsulamento (`private`)
* Getters e Setters
* Construtor (`__construct`)
* Relacionamento entre classes
* Organização em múltiplos arquivos
* Uso de `require_once`
* Manipulação de sessões (`$_SESSION`)
* Estruturação de interface com HTML e CSS
* Responsividade

---

## 📂 Estrutura do Projeto

```
projeto_loja/
│
├── index.php
├── clientes.php
├── produtos.php
├── pedidos.php
├── style.css
│
├── includes/
│   └── menu.php
│
└── classes/
    ├── Cliente.php
    ├── Produto.php
    └── Pedido.php
```

---

## ⚙️ Como Executar

1. Instale o XAMPP (ou outro servidor local)
2. Coloque o projeto dentro da pasta:

```
htdocs/
```

3. Inicie o Apache no XAMPP
4. Acesse no navegador:

```
http://localhost/projeto_loja
```

---

## ⚠️ Observações

* Os dados são armazenados em **sessão (`$_SESSION`)**, ou seja:

  * ❌ Não são persistentes
  * ❌ São apagados ao fechar o navegador ou limpar sessão

---

## 🚀 Melhorias Futuras

* [ ] Adicionar quantidade de produtos no pedido
* [ ] Remover/editar pedidos
* [ ] Persistência com banco de dados (MySQL)
* [ ] Sistema de login
* [ ] Interface mais avançada

---

## 👩‍💻 Autora

Projeto desenvolvido por **Flávia da Silva de Oliveira**
📚 Estudante de programação

---

## 💡 Considerações Finais

Este projeto representa a aplicação prática dos conceitos fundamentais de PHP e POO, servindo como base para sistemas mais complexos no futuro.

---
