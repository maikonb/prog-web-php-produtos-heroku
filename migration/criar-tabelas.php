<?php

require_once(__DIR__ . "/../db/Db.php");
$sql = file_get_contents(__DIR__ . '"/../db/db-vendas-v1.sql');
$sqls = explode(';', $sql);

$db = Db::getInstance();
if ($db->connect()) {

  $res_all = true;
  foreach($sqls as $s) {
    $s = trim($s);
    if ($s != "") {
      if($res = $db->query($s))
        echo "$s \n[[[[ OK ]]]] \n\n";
      else
        echo "$s \n[[[[ ERRO ]]]] \n\n";
      $res_all = $res_all && $res;
    }
  }
  
  if ($res_all)
    echo "Tabelas criadas.\n";
  else  
    echo "Erro na criação das tabelas.\n";

}

exit;
