<?php

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Departamento.php');
require_once(__DIR__ . '/../../dao/DaoDepartamento.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoDepartamento = new DaoDepartamento($conn);
$daoDepartamento->inserir( new Departamento($_POST['nome']));
    
header('Location: ./index.php');

?>


