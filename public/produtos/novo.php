<?php

require_once(__DIR__ . '/../../templates/template-html.php');
require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../model/Departamento.php');
require_once(__DIR__ . '/../../dao/DaoDepartamento.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$marcas = $daoMarca->todos();
$daoDepartamento = new DaoDepartamento($conn);
$departamentos = $daoDepartamento->todos();


ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Produtos</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

                <form action="salvar.php" method="POST">

                    <div class="form-group">
                        <label for="nome">Nome do produto</label>
                        <input type="text" class="form-control" id="nome"
                            name="nome" placeholder="Produto" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" min="0.00" max="10000.00" 
                                step="0.01"  id="preco" 
                                name="preco" placeholder="Preço em R$" required>
                        </div>                            
                        <div class="form-group col-md-6">
                            <label for="estoque">Estoque</label>
                            <input type="number" class="form-control" id="estoque" 
                                name="estoque" placeholder="Estoque" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" name="marca" required>
<?php foreach($marcas as $marca) { ?>
                            <option value="<?php echo $marca->getId() ?>">
                                <?php echo $marca->getNome() ?>
                            </option>
<?php } ?>
                        </select>                        
                    </div>                    
                    <div class="form-group">
                        <label for="departamentos">Selecione os Departamentos</label>
                        <select multiple size="5" class="form-control" id="departamentos" 
                            name="departamentos[]"  aria-describedby="departamentosHelp"
                        >
<?php foreach($departamentos as $dep) { ?>
                            <option value="<?php echo $dep->getId() ?>">
                                <?php echo $dep->getNome() ?>
                            </option>
<?php } ?>
                        </select>
                        <small id="departamentosHelp" class="form-text text-muted">
                            Utilize as teclas 'ctrl' ou 'shift' para selecionar mais que um departamento.
                        </small>                        
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>

                </form> 


            </div>
        </div>
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


