<?php

require_once('../db/Db.php');
require_once('../model/Marca.php');
require_once('../dao/DaoMarca.php');


function DaoMarca_testar_inserir(DaoMarca $dao, Marca $marca): bool {
  echo "Testando 'inserir'... ";
  $ret = $dao->inserir($marca);
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoMarca_testar_porId(DaoMarca $dao, Marca $marca): bool {
  echo "Testando 'porId()'... ";
  $id = $marca->getId();
  $marcaById = $dao->porId($id);
  $ret =  (!is_null($marcaById)) && 
          $marcaById->getId() == $marca->getId() &&
          $marcaById->getNome() == $marca->getNome() ;
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoMarca_testar_todos(DaoMarca $dao, Marca $marca): bool {
  echo "Testando 'todos()'... ";
  $ret = false;
  $marcas = $dao->todos();
  if (is_array($marcas) && count($marcas)>0 ) {
    foreach($marcas as $d) {
      $ret =  $d->getId() == $marca->getId() &&
              $d->getNome() == $marca->getNome();
      if ($ret) break;
    }
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoMarca_testar_atualizar(DaoMarca $dao, Marca $marca): bool {
  echo "Testando 'atualizar()'... ";
  $ret = false;
  $novoNome = $marca->getNome() . '[modificado]';
  $marca->setNome( $novoNome );
  if ( $dao->atualizar($marca) ) {
    $marcaAtualizado = $dao->porId( $marca->getId() );
    $ret = $marcaAtualizado->getNome() === $novoNome;
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoMarca_testar_remover(DaoMarca $dao, Marca $marca): bool {
  echo "Testando 'remover()'... ";
  $ret = false;
  if ( $dao->remover($marca) ) {
    $marcaRemovido = $dao->porId( $marca->getId() );
    $ret = is_null($marcaRemovido);
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}


function testar_DaoMarca(): bool {
  echo "<h2>Testando DaoMarca</h2>\n";

  $db = new Db("localhost", "user", "user", "vendas");

  if ($db->connect()) {
    $daoDep = new DaoMarca($db);
    $marca = new Marca("marca teste");

    DaoMarca_testar_inserir($daoDep, $marca);
    DaoMarca_testar_porId($daoDep, $marca);
    DaoMarca_testar_todos($daoDep, $marca);
    DaoMarca_testar_atualizar($daoDep, $marca);
    DaoMarca_testar_remover($daoDep, $marca);

    return true;
  }
  else {
    echo "<p>Erro na conexão com o banco de dados.</p>\n";
    return false;
  }    
}

// testar_DaoMarca();
