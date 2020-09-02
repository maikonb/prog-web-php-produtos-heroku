<?php

require_once('../db/Db.php');
require_once('../model/Produto.php');
require_once('../model/Marca.php');
require_once('../dao/DaoProduto.php');
require_once('../dao/DaoMarca.php');

function DaoProd_testar_inserir(DaoProduto $dao, Produto $prod): bool {
  echo "Testando 'inserir'... ";
  $ret = $dao->inserir($prod);
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoProd_testar_porId(DaoProduto $dao, Produto $prod): bool {
  echo "Testando 'porId()'... ";
  $id = $prod->getId();
  $prodById = $dao->porId($id);
  $ret =  (!is_null($prodById)) &&
          $prodById->getId() == $prod->getId() && 
          $prodById->getNome() == $prod->getNome() && 
          $prodById->getPreco() == $prod->getPreco()  &&
          $prodById->getEstoque() == $prod->getEstoque()  &&
          !is_null($prodById->getMarca()) &&
          $prodById->getMarca()->getId() == $prod->getMarca()->getId();
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoProd_testar_todos(DaoProduto $dao, Produto $prod): bool {
  echo "Testando 'todos()'... ";
  $ret = false;
  $prods = $dao->todos();
  if (is_array($prods) && count($prods)>0 ) {
    foreach($prods as $p) {
      $ret =  $p->getId() == $prod->getId() && 
              $p->getNome() == $prod->getNome() && 
              $p->getPreco() == $prod->getPreco()  &&
              $p->getEstoque() == $prod->getEstoque()  &&
              !is_null($p->getMarca()) &&
              $p->getMarca()->getId() == $prod->getMarca()->getId();
      if ($ret) break;
    }
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoProd_testar_atualizar(DaoProduto $daoProd, Marca $novaMarca, Produto $prod): bool {
  echo "Testando 'atualizar()'... ";
  $ret = false;
  
  $novoNome = $prod->getNome() . '[modificado]';
  $novoPreco = 555.88;
  $novoEstoque = 89;

  $prod->setNome( $novoNome );
  $prod->setPreco( $novoPreco );
  $prod->setEstoque( $novoEstoque );
  $prod->setMarca( $novaMarca );

  if ( $daoProd->atualizar($prod) ) {
    $p = $daoProd->porId( $prod->getId() );

    $ret =  $p->getId() == $prod->getId() && 
            $p->getNome() == $novoNome && 
            $p->getPreco() == $novoPreco  &&
            $p->getEstoque() == $novoEstoque  &&
            !is_null($p->getMarca()) &&
            $p->getMarca()->getId() == $novaMarca->getId();
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoProd_testar_remover(DaoProduto $dao, Produto $prod): bool {
  echo "Testando 'remover()'... ";
  $ret = false;
  if ( $dao->remover($prod) ) {
    $prodRemovido = $dao->porId( $prod->getId() );
    $ret = is_null($prodRemovido);
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}


function testar_DaoProduto(): bool {
  echo "<h2>Testando DaoProduto</h2>\n";

  $db = new Db("localhost", "user", "user", "vendas");

  if ($db->connect()) {
    $daoMarca = new DaoMarca($db);
    $daoProd = new DaoProduto($db);

    $marca = new Marca("marca 1");
    $daoMarca->inserir($marca);
    $novaMarca = new Marca("marca 2");
    $daoMarca->inserir($novaMarca);

    $prod = new Produto("produto teste", 900.99, 888, $marca);

    DaoProd_testar_inserir($daoProd, $prod);
    DaoProd_testar_porId($daoProd, $prod);
    DaoProd_testar_todos($daoProd, $prod);
    DaoProd_testar_atualizar($daoProd, $novaMarca, $prod);
    DaoProd_testar_remover($daoProd, $prod);

    $daoMarca->remover( $marca );
    $daoMarca->remover( $novaMarca );

    return true;
  }
  else {
    echo "<p>Erro na conexão com o banco de dados.</p>\n";
    return false;
  }    
}

//testar_DaoProduto();
