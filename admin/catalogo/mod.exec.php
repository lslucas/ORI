<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


  $res['data'] = datept2en('/',$res['data']);
  # include de mensagens do arquivo atual
  include_once 'inc.exec.msg.php';

 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_titulo FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_titulo=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['titulo']); 
 $qry_valida->execute();

  #se existe um titulo/nome/email assim nao passa
  if ($qry_valida->num_rows<>0 && $act=='insert') {
   echo $msgDuplicado;

  #se nao existe faz a inserção
  } else {

     $qry_valida->close();

     #autoinsert
     include_once $rp.'inc.autoinsert.php';

    $resumo = $res['resumo'];
    $descricao = $res['descricao'];
    $obs = $res['obs'];
    $valor = Currency2Decimal($res['valor'], 1);
    $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET

            ${var['pre']}_cat_id=?,
            ${var['pre']}_titulo=?,
            ${var['pre']}_data=?,
            ${var['pre']}_cat_id=?,
            ${var['pre']}_codigo=?,
            ${var['pre']}_descricao=?,
            ${var['pre']}_resumo=?,
            ${var['pre']}_valor=?,
            ${var['pre']}_obs=?,
            ${var['pre']}_home=?
          	";
     $sql.=" WHERE ${var['pre']}_id=?";


		if(!($qry=$conn->prepare($sql))) 
			echo $conn->error;

		else {

		  $qry->store_result();
		  $qry->bind_param('ississsdsii', $res['cat_id'], $res['titulo'], $res['data'], $res['cat_id'], $res['codigo'], $descricao, $resumo, $valor, $obs, $res['home'], $res['item']); 

		  $qry->execute();

		}


   if ($qry==false) echo $msgExiste;
    else {
    
	$qry->close();
     #insere as fotos/galeria do artigo
     include_once 'mod.exec.galeria.php';

     echo $msgSucesso;

    }

 }
