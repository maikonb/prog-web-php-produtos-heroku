<?php

require_once(__DIR__ . '/../templates/template-html.php');
require_once(__DIR__ . '/../db/Db.php');
require_once(__DIR__ . '/../model/Departamento.php');
require_once(__DIR__ . '/../dao/DaoDepartamento.php');
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../model/Marca.php');
require_once(__DIR__ . '/../dao/DaoMarca.php');
require_once(__DIR__ . '/../model/Produto.php');
require_once(__DIR__ . '/../dao/DaoProduto.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$daoProduto = new DaoProduto($conn);
$daoDepartamento = new DaoDepartamento($conn);

$marcas = $daoMarca->todos();
$departamentos = $daoDepartamento->todos();
$produtos = $daoProduto->todos();


ob_start();

?>
<div class="container">
  <div class="py-5 text-center">
    <h2>Vendas</h2>
  </div>
  <div class="row">

    <!-- Departamentos -->
    <div class="col-md-4" >
      <h3>Departamentos</h3>
      <?php 
        if (count($departamentos) >0) {
          echo "<ul>";
          foreach($departamentos as $d) 
            echo "<li>[" . $d->getId() . "] - " . $d->getNome() . "</li>";
          echo "</ul>";
        }
        else
          echo "<h4>Nenhum departamento cadastrado</h4>";
      ?>
    </div>

    <!-- Marcas -->
    <div class="col-md-4" >
      <h3>Marcas</h3>
      <?php 
        if (count($marcas) >0) {
          echo "<ul>";
          foreach($marcas as $m) 
            echo "<li>[" . $m->getId() . "] - " . $m->getNome() . "</li>";
          echo "</ul>";
        }
        else
          echo "<h4>Nenhuma marca cadastrada</h4>";
      ?>
    </div>


    <!-- Produtos -->
    <div class="col-md-4" >
      <h3>Produtos</h3>
      <?php 
        if (count($produtos) >0) {
          echo "<ul>";
          foreach($produtos as $p) {
            echo "<li>[" . $p->getId() . "] - " . 
                      $p->getNome() . " - " . 
                      $p->getMarca()->getNome() . "</li>";
          }
          echo "</ul>";
        }
        else
          echo "<h4>Nenhum produto cadastrado</h4>";
      ?>
    </div>


  </div>
</div>

<?php

$content = ob_get_clean();
echo html( $content, "./" );
    
?>


