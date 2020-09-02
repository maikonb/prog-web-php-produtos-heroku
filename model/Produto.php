<?php 

require_once('Marca.php');

class Produto {
    
  private $id;
  private $nome;
  private $preco;
  private $estoque;
  private $marca;
  private $departamentos = [];

  public function __construct(string $nome="", float $preco=0.0, $estoque=0, Marca $marca=null, int $id=-1) {
      $this->id = $id;
      $this->nome = $nome;
      $this->preco = $preco;
      $this->estoque = $estoque;
      $this->marca = $marca;
      $this->departamentos = [];
  }
  
  public function setId(int $id) {
      $this->id = $id;
  }

  public function getId() {
      return $this->id;
  }
  
  public function setNome(string $nome) {
      $this->nome = $nome;
  }

  public function getNome() {
      return $this->nome;
  }
  
  public function setPreco(float $preco) {
      $this->preco = $preco;
  }

  public function getPreco() {
      return $this->preco;
  }

  public function setMarca(Marca $marca) {
      $this->marca = $marca;
  }
  
  public function getMarca() {
      return $this->marca;
  }

  public function setEstoque(int $estoque) {
    $this->estoque = $estoque;
  }

  public function getEstoque() {
    return $this->estoque;
  }

  public function setDepartamentos(array $departamentos) {
    $this->departamentos = $departamentos;
  }

  public function getDepartamentos() {
    return $this->departamentos;
  }
};


