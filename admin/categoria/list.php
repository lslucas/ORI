<?php

  /*
   *quarda marcas
   */
/*
  $sql_marcas = "SELECT cat_titulo, cat_id FROM ".TABLE_PREFIX."_categoria WHERE cat_area='Marca'";
  $qry_marcas = $conn->prepare($sql_marcas);
  $qry_marcas->bind_result($nome, $id);
  $qry_marcas->execute();
  $marcas = array();
 
	  while ($qry_marcas->fetch()) {
		  $marcas[$id] = $nome;
	  }

  $qry_marcas->close();


//filtro
$whr = isset($_GET['a'])?$_GET['a']:'';
$where    = !empty($whr)
	  ? " WHERE ${var['pre']}_area='{$whr}'"
	  : " ";
 */
$where = null;


$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_area,
		${var['pre']}_idrel,
		${var['pre']}_status,
		(SELECT rcg_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_galeria WHERE rcg_${var['pre']}_id=${var['pre']}_id ORDER BY rcg_pos DESC LIMIT 1) imagem 
		
		FROM ".TABLE_PREFIX."_${var['path']} 
	  {$where}
		ORDER BY cat_area, cat_titulo ASC";

 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $nome, $area, $idrel, $status, $imagem);
	$qry->store_result();
	$total = $qry->num_rows;

    switch($total) {
       case $total==0: $total = 'Nenhum ítens';
      break;
       case $total==1: $total = "1 ítem";
      break;
       default: $total = $total.' ítens';
      break;
    }
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<?php /*
<div class='small' align='right'><?=$total?></div>
	<p>
	Filtrando por: <?=!empty($whr) ? $whr : 'todas as áreas'?>
	</p>
  <?php
    #listas de sub-navegação

    $area
	$area = array('Marca', 'Modelo', 'Carroceria', 'Cor', 'Opcionais');
	foreach($area as $id) {

		if($whr<>$id) 
		 echo "<a href='${rp}?p=${p}&a={$id}'>";
		 else echo '<b>';

		echo $id;

		if($whr<>$id) echo '</a>';
		  else echo '</b>';

		echo '&nbsp;|&nbsp;';

	}

     #todos
    if(!empty($whr)) 
     echo "<a href='${rp}?p=${p}' class='color-negative'>";
     else echo '<b>';

    echo 'Mostrar TODAS as áreas';

    if(!empty($whr)) echo '</a>';
      else echo '</b>';

	*/

  ?>


<table class="list">
   <thead> 
      <tr>
        <th width="25px"></th>
        <th width="100px">Área</th>
        <th style='min-width:120px;'>Título</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

		$marca = isset($marcas[$idrel]) ? $marcas[$idrel].' ' : null;

# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_images = "&prefix=r_${var['pre']}_galeria&pre=rcg&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id${delete_images}&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a> | 
<a href='?p={$p}&status&item={$id}&noVisual' title="Clique para alterar o status do ítem selecionado" class='tip status status{$id}' style="cursor:pointer;" id="{$id}" name='{$nome}'>
end;
if ($status==1) 
	$row_actions .= '<font color="#000000">Ativo</font>'; 
else $row_actions .=  '<font color="#999999">Pendente</font>';

$row_actions .= "</a>";
?>
      <tr id="tr<?=$id?>">
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
        <td><?=$area?></td>
        <td>
	
	<?=$marca.$nome?>
	<div class='row-actions'><?=$row_actions?></div></td>
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
?>
