<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Produto.php');
require_once(__DIR__ . '/../../dao/DaoProduto.php');
require_once(__DIR__ . '/../../dao/DaoDepartamento.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$produto_id = $_GET['id'];

$daoMarca = new DaoMarca($conn);
$marcas = $daoMarca->todos();
$daoDepartamento = new DaoDepartamento($conn);
$departamentos = $daoDepartamento->todos();
$daoProduto = new DaoProduto($conn);
$produto = $daoProduto->porId( $produto_id );

if (! $produto )
    header('Location: ./index.php');

else {  

    $daoProduto->carregarDepartamentos($produto);
    $departamentos_ids = array_reduce($produto->getDepartamentos(), 
        function($ids, Departamento $dep) {
            $ids[] = $dep->getId();
            return $ids;
        }, []
    );

    ob_start();

    ?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Produtos</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

                <form action="atualizar.php" method="POST">

                    <input type="hidden" name="id" 
                          value="<?php echo $produto->getId(); ?>"> 

                    <div class="form-group">
                        <label for="nome">Nome do produto</label>
                        <input type="text" class="form-control" id="nome"
                            value="<?php echo $produto->getNome(); ?>"
                            name="nome" placeholder="Produto" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" min="0.00" max="10000.00" 
                                step="0.01"  id="preco" 
                                value="<?php echo $produto->getPreco(); ?>"
                                name="preco" placeholder="Preço em R$" required>
                        </div>                            
                        <div class="form-group col-md-6">
                            <label for="estoque">Estoque</label>
                            <input type="number" class="form-control" id="estoque" 
                                value="<?php echo $produto->getEstoque(); ?>"
                                name="estoque" placeholder="Estoque" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" name="marca" required>
<?php foreach($marcas as $marca) { ?>
                            <option value="<?php echo $marca->getId() ?>"
                                <?php 
                                    if ($marca->getId() == $produto->getMarca()->getId()) 
                                        echo 'selected'; 
                                ?>
                            >
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
                            <option value="<?php echo $dep->getId() ?>"
                                <?php 
                                    if ( in_array($dep->getId(), $departamentos_ids)) 
                                        echo 'selected';
                                ?>
                            >
                                <?php echo $dep->getNome() ?>
                            </option>
<?php } ?>
                        </select>
                        <small id="departamentosHelp" class="form-text text-muted">
                            Utilize as teclas 'ctrl' ou 'shift' para selecionar mais que um departamento.
                        </small>                        
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>

                </form> 


            </div>
        </div>
    </div>
<?php


    $content = ob_get_clean();
    echo html( $content );
} // else-if

?>
