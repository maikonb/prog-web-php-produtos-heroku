<?php 
require_once(__DIR__ . '/../model/Marca.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Marcas 
// DAO - Data Access Object
class DaoMarca {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Marca {
    $sql = "SELECT nome FROM marcas where id = ?";
    $stmt = $this->connection->prepare($sql);
    $dep = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $nome = '';
        $stmt->bind_result($nome);
        $stmt->store_result();
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $dep = new Marca($nome, $id);
        }
      }
      $stmt->close();
    }
    return $dep;
  }

  public function inserir(Marca $marca): bool {
    $sql = "INSERT INTO marcas (nome) VALUES(?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $marca->getNome();
      $stmt->bind_param('s', $nome);
      if ($stmt->execute()) {
          $id = $this->connection->getLastID();
          $marca->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Marca $marca): bool {
    $sql = "DELETE FROM marcas where id=?";
    $id = $marca->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Marca $marca): bool {
    $sql = "UPDATE marcas SET nome = ? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
      $nome = $marca->getNome();
      $id   = $marca->getId();
      $stmt->bind_param('si', $nome, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT id, nome from marcas";
    $stmt = $this->connection->prepare($sql);
    $marcas = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; $nome = '';
        $stmt->bind_result($id, $nome);
        $stmt->store_result();
        while($stmt->fetch()) {
          $marcas[] = new Marca($nome, $id);
        }
      }
      $stmt->close();
    }
    return $marcas;
  }

};

