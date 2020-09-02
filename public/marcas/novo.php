<?php

require_once(__DIR__ . '/../../templates/template-html.php');
ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Marcas</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

              <form action="salvar.php" class="card p-2 my-4" method="POST">
                  <div class="input-group">
                      <input type="text" placeholder="Nome da Marca" 
                          class="form-control" name="nome" required>
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-primary">
                              Salvar
                          </button>
                      </div>
                  </div>
              </form>
              <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>


            </div>
        </div>
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


