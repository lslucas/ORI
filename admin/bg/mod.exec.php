<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


     #autoinsert
     include_once $rp.'inc.autoinsert.php';


     #insere as fotos/galeria do artigo
     include_once 'mod.exec.galeria.php';

?>
<script>window.location='<?=$rp?>index.php?p=<?=$p?>&update&item=<?=$res['item']?>';</script>
