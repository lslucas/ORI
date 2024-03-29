<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';

 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido

 $sql_valida = "SELECT ${var['pre']}_cat_id FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_cat_id=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('i', $res['cat_id']); 
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


    $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET ${var['pre']}_cat_id=?";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('ii', $res['cat_id'], $res['item']); 
     $qry->execute();


   if ($qry==false) echo $msgExiste;
    else {
     
     $qry->close();
     #insere as fotos/galeria do artigo
	 include_once 'mod.exec.galeria.php';
    
     echo $msgSucesso;

    }

 }
