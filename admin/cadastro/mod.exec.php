<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_email retorno FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_email=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['email']); 
 $qry_valida->execute();
 $qry_valida->store_result();

  #se existe um titulo/nome/email assim nao passa
  if ($qry_valida->num_rows<>0 && $act=='insert') {
   echo $msgDuplicado;
   $qry_valida->close();


  #se nao existe faz a inserção
  } else {

     #autoinsert
     include_once $rp.'inc.autoinsert.php';


  		  //${var['pre']}_nome=?,
     $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET
  		  ${var['pre']}_email=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('si',$res['email'], $res['item']); 
     $qry->execute();


   if ($qry==false) echo $msgExiste;
    else {
     
     $qry->close();
     echo $msgSucesso;


     }


 }
