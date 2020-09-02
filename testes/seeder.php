<?php

require_once('../db/Db.php');
require_once('../model/Departamento.php');
require_once('../dao/DaoDepartamento.php');

$db = new Db("localhost", "user", "user", "vendas");

if ($db->connect()) {

  $daoDep = new DaoDepartamento($db);

  echo "<h2>Inserindo Departamentos</h2>\n"; 
  $daoDep->inserir(new Departamento("Eletrônicos"));
  $daoDep->inserir(new Departamento("Roupas"));
  $daoDep->inserir(new Departamento("Informática"));
  $daoDep->inserir(new Departamento("Bebidas"));
  $daoDep->inserir(new Departamento("Acessórios automotivos"));
  

}
else {
  echo "<p>Erro na conexão com o banco de dados.</p>\n";
}    

