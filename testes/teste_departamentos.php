<?php

require_once('../db/Db.php');
require_once('../model/Departamento.php');
require_once('../dao/DaoDepartamento.php');

function DaoDep_testar_inserir(DaoDepartamento $dao, Departamento $dep): bool {
  echo "Testando 'inserir'... ";
  $ret = $dao->inserir($dep);
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoDep_testar_porId(DaoDepartamento $dao, Departamento $dep): bool {
  echo "Testando 'porId()'... ";
  $id = $dep->getId();
  $depById = $dao->porId($id);
  $ret =  (!is_null($depById)) && 
          $depById->getId() == $dep->getId() &&
          $depById->getNome() == $dep->getNome() ;
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoDep_testar_todos(DaoDepartamento $dao, Departamento $dep): bool {
  echo "Testando 'todos()'... ";
  $ret = false;
  $deps = $dao->todos();
  if (is_array($deps) && count($deps)>0 ) {
    foreach($deps as $d) {
      $ret =  $d->getId() == $dep->getId() &&
              $d->getNome() == $dep->getNome();
      if ($ret) break;
    }
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoDep_testar_atualizar(DaoDepartamento $dao, Departamento $dep): bool {
  echo "Testando 'atualizar()'... ";
  $ret = false;
  $novoNome = $dep->getNome() . '[modificado]';
  $dep->setNome( $novoNome );
  if ( $dao->atualizar($dep) ) {
    $depAtualizado = $dao->porId( $dep->getId() );
    $ret = $depAtualizado->getNome() === $novoNome;
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoDep_testar_remover(DaoDepartamento $dao, Departamento $dep): bool {
  echo "Testando 'remover()'... ";
  $ret = false;
  if ( $dao->remover($dep) ) {
    $depRemovido = $dao->porId( $dep->getId() );
    $ret = is_null($depRemovido);
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}




function testar_DaoDepartamento(): bool {
  echo "<h2>Testando DaoDepartamento</h2>\n"; 

  $db = new Db("localhost", "user", "user", "vendas");

  if ($db->connect()) {
    $daoDep = new DaoDepartamento($db);
    $dep = new Departamento("departamento teste");

    DaoDep_testar_inserir($daoDep, $dep);
    DaoDep_testar_porId($daoDep, $dep);
    DaoDep_testar_todos($daoDep, $dep);
    DaoDep_testar_atualizar($daoDep, $dep);
    DaoDep_testar_remover($daoDep, $dep);

    return true;
  }
  else {
    echo "<p>Erro na conexão com o banco de dados.</p>\n";
    return false;
  }    
}

// testar_DaoDepartamento();