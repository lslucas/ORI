<?php

  /*
   *busca total de itens e faz variaveis de paginação
   */
/*
  $sql_letras = "SELECT UPPER(LEFT(cad_nome, 1)) FROM ".TABLE_PREFIX."_${var['path']} GROUP BY LEFT(cad_nome, 1) ORDER BY cad_nome";

  if($qry_letras = $conn->prepare($sql_letras)) {

    $qry_letras->execute();
    $qry_letras->bind_result($letra);

    if(!isset($_GET['letra']) || empty($_GET['letra'])) {
    $letras = 'Todos - ';
    $countLetra = '';

    } else {
      $letras = "<a href='?p=cadastro'>Todos</a> - ";
      $countLetra = ' com a letra '.$_GET['letra'];
    }


      while($qry_letras->fetch()) {
        if(!isset($_GET['letra']) || $letra<>$_GET['letra'])
        $letras .= "<a href='?p=cadastro&letra=${letra}'>";
        $letras .= $letra;
        if(!isset($_GET['letra']) || $letra<>$_GET['letra'])
        $letras .= "</a>";
        $letras .= " - ";
      }

    $letras = substr($letras, 0, -2);
    $qry_letras->close();

  }


  $where = '';
  if( isset($_GET['letra']) && !empty($_GET['letra']) ) {
    $where = " WHERE cad_nome LIKE '".$_GET['letra']."%' ";
  }
 */
$where = null;


/*
 *busca total de itens e faz variaveis de paginação
 */
$sql_tot = "SELECT NULL FROM ".TABLE_PREFIX."_${var['path']} $where";
$qry_tot = $conn->query($sql_tot);

$total_itens = $qry_tot->num_rows;
$limit_end   = 30;
$n_paginas   = ceil($total_itens/$limit_end);
$pg_atual    = isset($_GET['pg']) && !empty($_GET['pg'])?$_GET['pg']:1;
$limit_start = ceil(($pg_atual-1)*$limit_end);

$qry_tot->close();


$orderby = !isset($_GET['orderby'])?$var['pre'].'_nome ASC':urldecode($_GET['orderby']);


$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_nome,
		${var['pre']}_email,
		DATE_FORMAT(${var['pre']}_timestamp,'%d/%m/%Y') timestamp,
		${var['pre']}_status
		
		FROM ".TABLE_PREFIX."_${var['path']} 
    $where
    ORDER BY $orderby

    LIMIT $limit_start,$limit_end
    ";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id,$nome,$email,$timestamp,$status);


    switch($total_itens) {
       case $total_itens==0: $total = 'Nenhum cadastro';
      break;
       case $total_itens==1: $total = "1 cadastro";
      break;
       default: $total = $total_itens.' cadastros';
      break;
    }
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<div class='small' align='right'><?=$total?></div>
<!--
<p>
Filtrar por: <?php //$letras?>
</p><br/>
-->

<a href='cadastro/mod.exec_xls.php' target='_blank' class='small'>Exportar Excel</a>
<?php /*
<span class='min' style='margin-left:20px;'>Ordernar por:
<select name='orderby' id='orderby' class='min'>
<option value='<?=$var['pre'].'_timestamp'?> ASC'<?php if($orderby==$var['pre'].'_timestamp ASC') echo ' selected';?>>Data crescente</option>
  <option value='<?=$var['pre'].'_timestamp'?> DESC'<?php if($orderby==$var['pre'].'_timestamp DESC') echo ' selected';?>>Data decrescente</option>
  <option value='<?=$var['pre'].'_nome'?> ASC'<?php if($orderby==$var['pre'].'_nome ASC') echo ' selected';?>>Nome crescente</option>
  <option value='<?=$var['pre'].'_nome'?> DESC'<?php if($orderby==$var['pre'].'_nome DESC') echo ' selected';?>>Nome decrescente</option>
</select>
 */?>
</span>
<table class="list">
   <thead> 
      <tr>
<!--        <th width="5px"><input type='checkbox' name='check-all' value='1'></th>-->
        <th width="35px">Cadastro</th>
        <th style='min-width:120px;'>Email</th>
        <th width="55px"></th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$row_actions = <<<end
<a href='?p=$p&delete&item=$id&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$email'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;
$permissoes='';
?>
      <tr id="tr<?=$id?>">
<!--        <td><input type='checkbox' name='check' value='1'></td>-->
        <td><?=$timestamp?></td>
        <td>
	<a href='mailto:<?=$email?>'><?=$email?></a>
	<div class='row-actions'><?=$row_actions?></div></td>

        <td align='center'><a href='?p=<?=$p?>&status&item=<?=$id?>&noVisual' title="Clique para alterar o status do ítem selecionado" class='tip status status<?=$id?>' style="cursor:pointer;" id="<?=$id?>" name='<?=$email?>'><?php if ($status==1) echo'<font color="#000000">Ativo</font>'; else echo '<font color="#999999">Bloqueado</font>'; ?></a></td>
      </tr>



<?php
     $j++;
    }

    $qry->close();
?>
    </tbody>
    </table>


	  <?php
        /*
         *paginação
         */
        #$nav_cat       = isset($catid)?'&cat='.$catid:'';
		$queryString = preg_replace("/(\?|&)?(pg=[0-9]{1,})/",'',$_SERVER['QUERY_STRING']);
        $nav_cat='&'.$queryString;

	      $nav_nextclass = $pg_atual==$n_paginas?'unstyle ':'';
	      $nav_nexturl   = $pg_atual==$n_paginas?'javascript:void(0)':'?pg='.($pg_atual+1).$nav_cat;

        echo "<div class='spacer' style='height:30px;'></div>";
	      echo "<span style='float:left'>";
	      echo "  <a href='${nav_nexturl}' class='${nav_nextclass}navbar more'>Mais ítens</a>";
	      echo "</span>";


	      echo "<span style='float:right'>";

	      $nav_prevclass = $pg_atual==1?'unstyle ':'';
	      $nav_prevurl   = $pg_atual==1?'javascript:void(0)':'?pg=1'.$nav_cat;
	
	      echo "<a href='${nav_prevurl}' class='${nav_prevclass}navbar prev'>Anterior</a>";
	

	    for($p=1;$p<=$n_paginas;$p++) {

	      $nav_class = $pg_atual<>$p?'':'unstyle ';
	      $nav_url   = $pg_atual==$p?'javascript:void(0)':'?pg='.$p.$nav_cat;
	  ?>
	  <a href='<?=$nav_url?>' class='<?=$nav_class?> navbar'><?=$p?></a>
	  <?php

	    }

	    echo "<a href='${nav_nexturl}' class='${nav_nextclass}navbar next'>Próximo</a>";
	    echo "</span>";
	  ?>
	</div>




<?php

  }
?>

