<?php 

class Departamento {

  private $id;
  private $nome;

  public function __construct(string $nome='', int $id=-1) {
      $this->id = $id;
      $this->nome = $nome;
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
  
};