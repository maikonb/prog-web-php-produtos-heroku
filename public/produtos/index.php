<?php

require_once(__DIR__ . '/../../templates/template-html.php');
require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Produto.php');
require_once(__DIR__ . '/../../dao/DaoProduto.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoProduto = new DaoProduto($conn);
$produtos = $daoProduto->todos();

ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Produtos</h2>
        </div>
        <div class="row mb-2">
            <div class="col-md-12" >
                <a href="novo.php" class="btn btn-primary active" role="button" aria-pressed="true">Novo Produto</a>
            </div>
        </div>

<?php 
    if (count($produtos) >0) 
    {
?>
        <div class="row">
            <div class="col-md-12" >

                <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Estoque</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
<?php 
        foreach($produtos as $p) {
?>                    
                    <tr>
                        <th scope="row"><?php echo  $p->getId(); ?></th>
                        <td><?php echo $p->getNome(); ?></td>
                        <td><?php echo $p->getMarca()->getNome(); ?></td>
                        <td><?php echo $p->getEstoque(); ?></td>
                        <td>
                            <a class="btn btn-danger btn-sm active" 
                                href="apagar.php?id=<?php echo $p->getId();?>">
                                Apagar
                            </a>
                            <a class="btn btn-secondary btn-sm active" 
                                href="editar.php?id=<?php echo $p->getId();?>">
                                Editar
                            </a>                        
                        </td>
                    </tr>
<?php
        } // foreach
?>                    
                </tbody>
                </table>

            </div>
        </div>
<?php 
    
    }  // if 
?>        
    </div>
<?php

$content = ob_get_clean();
echo html( $content );
    
?>


