<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Marca.php');
require_once(__DIR__ . '/../../dao/DaoMarca.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoMarca = new DaoMarca($conn);
$daoMarca->inserir( new Marca($_POST['nome']));
    
header('Location: ./index.php');

?>


