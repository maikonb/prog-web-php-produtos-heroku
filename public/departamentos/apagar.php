<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Departamento.php');
require_once(__DIR__ . '/../../dao/DaoDepartamento.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoDepartamento = new DaoDepartamento($conn);

// Se for confirmação, apago o registro e redireciono para o index.php
if (isset($_POST['id']) && isset($_POST['confirmacao'])) {
  $departamento = $daoDepartamento->porId( $_POST['id'] );
  $daoDepartamento->remover( $departamento );
  header('Location: ./index.php');
  exit;  // Termino a execucação desse script
}

// Se não for confirmação, exibo a confirmação
$departamento = $daoDepartamento->porId( $_GET['id'] );
if (! $departamento )
    header('Location: ./index.php');
else {  
    ob_start();
?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Apagar Departamento</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

              <form action="apagar.php" class="card p-2 my-4" method="POST">
                <input type="hidden" name="id" 
                  value="<?php echo $departamento->getId(); ?>"
                >
                <div class="form-group">
                  <label for="departamento">Deseja realmente apagar o departamento abaixo?</label>
                  <input type="text" class="form-control" id="departamento" aria-describedby="help" 
                    value="<?php echo $departamento->getNome();?>" 
                    readonly
                  >
                  <small id="help" class="form-text text-muted">Esta operação não poderá ser desfeita.</small>
                </div>
                <div class="form-row">
                  <input type="submit" class="btn btn-danger ml-1" value="Apagar" name="confirmacao"/>
                  <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>
                </div>
              </form>

            </div>
        </div>
    </div>
<?php
    $content = ob_get_clean();
    echo html( $content );
} // else-if
