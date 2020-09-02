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
$departamento = $daoDepartamento->porId( $_POST['id'] );
    
if ( $departamento )
{  
  $departamento->setNome( $_POST['nome'] );
  $daoDepartamento->atualizar( $departamento );
}

header('Location: ./index.php');