<?php
  /*
   *quarda marcas
   */
  $sql_marcas = "SELECT cat_titulo, cat_id FROM ".TABLE_PREFIX."_categoria WHERE cat_area='Catalogo'";
  $qry_marcas = $conn->prepare($sql_marcas);
  $qry_marcas->bind_result($nome, $id);
  $qry_marcas->execute();
  $categoria = array();
 
	  while ($qry_marcas->fetch()) {
		  $categoria[$id] = $nome;
	  }

  $qry_marcas->close();



//filtro
$whr = isset($_GET['m'])?(int)$_GET['m']:'';
$where    = is_int($whr)
	  ? " WHERE ${var['pre']}_cat_id=".$whr
	  : " ";


//query principal
$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_codigo,
		${var['pre']}_home,
		${var['pre']}_valor,
		(SELECT cat_titulo FROM ".TABLE_PREFIX."_categoria WHERE cat_id=${var['pre']}_cat_id) categoria,
		${var['pre']}_status,
		${var['pre']}_data data_en,
		DATE_FORMAT(${var['pre']}_data,'%d/%m/%y') data,
		(SELECT rci_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rci_${var['pre']}_id=${var['pre']}_id ORDER BY rci_pos DESC LIMIT 1) imagem 
		
		FROM ".TABLE_PREFIX."_${var['path']} 
		$where
		ORDER BY cata_cat_id, cata_data DESC";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $titulo, $codigo, $home, $valor, $cat, $status, $data_en, $data, $imagem);
    $qry->store_result();
    $num = $qry->num_rows;
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'>
<?='Mostrando produtos'?>
<?=empty($whr) ? ' de todas as categorias' : " da categoria ".$categoria[$whr]?>
</p>

  <?php
    /*
     *listas de sub-navegação
     */

   /*
    *marcas
    */
	foreach($categoria as $id=>$nome) {

		if($whr<>$id) 
		 echo "<a href='${rp}?p=${p}&m={$id}'>";
		 else echo '<b>';

		echo $nome;

		if($whr<>$id) echo '</a>';
		  else echo '</b>';

		echo '&nbsp;|&nbsp;';

	}

    /*
     *todos
     */
    if(!empty($whr)) 
     echo "<a href='${rp}?p=${p}' class='color-negative'>";
     else echo '<b>';

    echo 'Mostrar TODAS as categorias';

    if(!empty($whr)) echo '</a>';
      else echo '</b>';



  ?>




  <?php

    if($num==0) {
      echo "<br/>Nenhum produto!";

    } else {

   ?>

<table class="list">
   <thead> 
      <tr>
<!--        <th width="5px"><input type='checkbox' name='check-all' value='1'></th>-->
        <th width="25px"></th>
        <th width="60px">Data</th>
        <th style='min-width:120px;'>Título</th>
        <th width="400px">Categoria</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
		$exibir_home = $home==1 ? '<br/><i>Exibindo na home</i>' : null;
		$valor = !empty($valor) ? '<br/><i>R$ '.Moeda($valor).'</i>' : null;
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_images = "&prefix=r_${var['pre']}_imagem&pre=rci&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id${delete_images}&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$titulo'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a> | 
<a href='?p={$p}&status&item={$id}&noVisual' title="Clique para alterar o status do ítem selecionado" class='tip status status{$id}' style="cursor:pointer;" id="{$id}" name='{$titulo}'>
end;
if ($status==1) 
	$row_actions .= '<font color="#000000">Ativo</font>'; 
else $row_actions .=  '<font color="#999999">Pendente</font>';

$row_actions .= "</a>";
?>
      <tr id="tr<?=$id?>">
<!--        <td><input type='checkbox' name='check' value='1'></td>-->
        <td>
        <center>
	  <a id='ima<?=$j?>' href="$im<?=$j?>?width=100%" class="betterTip" style="cursor:pointer;">
	    <img src="images/lupa.gif">
	  </a>
	  
	  <div id="im<?=$j?>" style="float:left;display:none">
	      <?php 
	        $arquivo = substr($var['path_thumb'],0).'/'.$imagem;

		if (is_file($arquivo)) 
		  echo "<img src='{$arquivo}'>";

		  else 
		   echo 'sem imagem';
	      ?>
	  </div>
	</center>

	</td>
    <td><?=$data?></td>
    <td><?=$titulo.$exibir_home.$valor?>
		<div class='row-actions'><?=$row_actions?></div>
	</td>
	<td><?=$cat?></td>
   </tr>
<?php
     $j++;
    }

    $qry->close();
?>
    </tbody>
    </table>

<?php

   }
  }
?>

