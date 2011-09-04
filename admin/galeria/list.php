<?php
$where = null;
$sql = "SELECT  ${var['pre']}_id,
		(SELECT cat_titulo FROM ".TABLE_PREFIX."_categoria WHERE cat_id=${var['pre']}_cat_id) titulo,
		${var['pre']}_status,
		(SELECT rgi_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rgi_${var['pre']}_id=${var['pre']}_id ORDER BY rgi_pos ASC LIMIT 1) imagem 
		
		FROM ".TABLE_PREFIX."_${var['path']} 
	  {$where}
		ORDER BY gal_cat_id ASC";

 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $titulo, $status, $imagem);
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

<table class="list">
   <thead> 
      <tr>
        <th width="25px"></th>
        <th style='min-width:120px;'>Galeria</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_images = "&prefix=r_${var['pre']}_imagem&pre=rgi&col=imagem&folder=${var['imagem_folderlist']}";
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
        <td><?=$titulo?>
			<div class='row-actions'><?=$row_actions?></div>
	</td>
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
