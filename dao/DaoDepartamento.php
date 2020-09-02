<?php 
require_once(__DIR__ . '/../model/Departamento.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Departamentos 
// DAO - Data Access Object
class DaoDepartamento {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Departamento {
    $sql = "SELECT nome FROM departamentos where id = ?";
    $stmt = $this->connection->prepare($sql);
    $dep = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $nome = '';
        $stmt->bind_result($nome);
        $stmt->store_result();
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $dep = new Departamento($nome, $id);
        }
      }
      $stmt->close();
    }
    return $dep;
  }

  public function inserir(Departamento $departamento): bool {
    $sql = "INSERT INTO departamentos (nome) VALUES(?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $departamento->getNome();
      $stmt->bind_param('s', $nome);
      if ($stmt->execute()) {
          $id = $this->connection->getLastID();
          $departamento->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Departamento $departamento): bool {
    $sql = "DELETE FROM departamentos where id=?";
    $id = $departamento->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Departamento $departamento): bool {
    $sql = "UPDATE departamentos SET nome = ? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
      $nome = $departamento->getNome();
      $id   = $departamento->getId();
      $stmt->bind_param('si', $nome, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT id, nome from departamentos";
    $stmt = $this->connection->prepare($sql);
    $departamentos = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; $nome = '';
        $stmt->bind_result($id, $nome);
        $stmt->store_result();
        while($stmt->fetch()) {
          $departamentos[] = new Departamento($nome, $id);
        }
      }
      $stmt->close();
    }
    return $departamentos;
  }

};

