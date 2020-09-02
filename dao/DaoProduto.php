<?php 
require_once(__DIR__ . '/../model/Produto.php');
require_once(__DIR__ . '/../model/Marca.php');
require_once(__DIR__ . '/../model/Departamento.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Produtos 
// DAO - Data Access Object
class DaoProduto {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Produto {
    $sql = "SELECT produtos.nome, produtos.preco, 
                   produtos.estoque, produtos.marca_id, marcas.nome 
            FROM produtos 
            LEFT JOIN marcas ON marcas.id = produtos.marca_id
            WHERE produtos.id = ?";
    $stmt = $this->connection->prepare($sql);
    $prod = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $stmt->bind_result($nome,$preco,$estoque,$marca_id,$marca_nome);
        $stmt->store_result();
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $prod = new Produto($nome, $preco, $estoque, 
            new Marca($marca_nome, $marca_id), $id);
        }
      }
      $stmt->close();
    }
    return $prod;
  }

  public function inserir(Produto $produto): bool {
    $sql = "INSERT INTO produtos (nome,preco,estoque,marca_id) VALUES(?,?,?,?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $produto->getNome();
      $preco = $produto->getPreco();
      $estoque = $produto->getEstoque();
      $marca_id = $produto->getMarca()->getId();
      $stmt->bind_param('sdii', $nome, $preco, $estoque, $marca_id);
      if ($stmt->execute()) {
          $id = $this->connection->getLastID();
          $produto->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Produto $produto): bool {
    $sql = "DELETE FROM produtos where id=?";
    $id = $produto->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Produto $produto): bool {
    $sql = "UPDATE produtos SET nome=?, preco=?, estoque=?, marca_id=? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
      $nome = $produto->getNome();
      $preco = $produto->getPreco();
      $estoque = $produto->getEstoque();
      $marca_id = $produto->getMarca()->getId();      
      $id   = $produto->getId();
      $stmt->bind_param('sdiii', $nome, $preco, $estoque, $marca_id, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT produtos.id, produtos.nome, produtos.preco, 
                   produtos.estoque, produtos.marca_id, marcas.nome 
            FROM produtos 
            LEFT JOIN marcas ON marcas.id = produtos.marca_id";
    $stmt = $this->connection->prepare($sql);
    $produtos = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; $nome = '';
        $stmt->bind_result(
          $id, $nome, $preco, $estoque, $marca_id, $marca_nome
        );
        $stmt->store_result();
        while($stmt->fetch()) {
          // TODO: Criar uma unica instancia para cada marca
          //       de modo a otimizar a memoria.
          // Adotei a abordagem abaixo por ser mais rapido, 
          // mas nao eh eficiente          
          $marca = new Marca($marca_nome, $marca_id);
          $produtos[] = new Produto($nome, $preco, $estoque, $marca, $id);
        }
      }
      $stmt->close();
    }
    return $produtos;
  }

  public function sincronizarDepartamentos(Produto $prod, array $ids_departamentos_novos): bool {
    $id = $prod->getId();
    $sql = "SELECT departamento_id FROM produto_departamento 
            WHERE produto_id=$id";
    if ($res = $this->connection->query($sql)) {

      $array_ids = $res->fetch_all(MYSQLI_NUM);
      $ids_departamentos = array_map(function($a) { return $a[0]; }, $array_ids);
      $ids_apagar  = array_diff($ids_departamentos, $ids_departamentos_novos);
      $ids_inserir = array_diff($ids_departamentos_novos, $ids_departamentos);

      /* 
      // Para depurar e entender o código:
      echo "<br><br>ids_departamentos_novos:";
      var_dump($ids_departamentos_novos);
      echo "<br><br>ids_departamentos:";      
      var_dump($ids_departamentos);
      echo "<br><br>ids_inserir:";      
      var_dump($ids_inserir);
      echo "<br><br>ids_apagar"; 
      var_dump($ids_apagar);
      exit; 
      */
      
      if (count($ids_apagar) > 0) {
        $sql_apagar_in = implode(",", $ids_apagar); // Formato da saida: 10, 20, 30
        $sql_apagar  = "DELETE FROM produto_departamento 
                        WHERE produto_id=$id and departamento_id 
                        IN ( $sql_apagar_in )";
        $this->connection->query($sql_apagar);                   
      }
      if (count($ids_inserir) > 0) {
        $sql_inserir_values = array_reduce($ids_inserir, function($carry, $item) use($id) { 
          if ($carry=='')
            return "($id, $item)";
          return $carry . ", ($id, $item)";
        }, ''); // Formato da saida: (1,10), (1,20), (1, 30)
        $sql_inserir = "INSERT INTO produto_departamento (produto_id, departamento_id)
                        VALUES $sql_inserir_values ";
        $this->connection->query($sql_inserir);  
      }
      return true;
    }
    return false;
  }


  public function carregarDepartamentos(Produto $prod): bool {
    $id = $prod->getId();
    $sql = "SELECT departamentos.id, departamentos.nome FROM produto_departamento
            LEFT JOIN departamentos ON departamentos.id=produto_departamento.departamento_id
            WHERE produto_id=$id";

    if ($res = $this->connection->query($sql)) {
      $departamentos_assoc = $res->fetch_all(MYSQLI_ASSOC);
      $departamentos = [];
      foreach($departamentos_assoc as $d) {
        $departamentos[] = new Departamento($d['nome'], $d['id']);
      }
      $prod->setDepartamentos($departamentos);
      return true;
    }
    return false;
  }

};

