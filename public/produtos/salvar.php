<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Produto.php');
require_once(__DIR__ . '/../../dao/DaoProduto.php');
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$daoProduto = new DaoProduto($conn);

$marca = $daoMarca->porId( $_POST['marca'] );

$novoProduto = new Produto($_POST['nome'], $_POST['preco'], $_POST['estoque'], $marca);

if ($daoProduto->inserir( $novoProduto) ) {
    $daoProduto->sincronizarDepartamentos($novoProduto, $_POST['departamentos']);
}
    
header('Location: ./index.php');

?>


