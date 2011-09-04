<?php

$sql = "SELECT 
		${var['pre']}_id,
		${var['pre']}_imagem

	  FROM ".TABLE_PREFIX."_${var['table']}
	  ";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id,$imagem);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>

<!--
<select name='actions' class='min'>
  <option value=''>Ações</option>
  <option value='remove'>Remover</option>
  <option value='on'>Ativar</option>
  <option value='off'>Desativar</option>
</select>
<input type='button' value='aplicar' class='min'>
-->
<table class="list">
   <thead> 
      <tr>
<!--        <th width="5px"><input type='checkbox' name='check-all' value='1'></th>-->
        <th></th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

     #trata caso link esteja vazio
     $link = empty($link)?'[vazio]':$link;


# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_images = "&prefix=${var['path']}&pre=${var['pre']}&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;
$permissoes='';
?>
      <tr id="tr<?=$id?>">
<!--        <td><input type='checkbox' name='check' value='1'></td>-->
        <td>
        <center>
	<div><?=$row_actions?></div>
	      <?php 
	        $arquivo = substr($var['path_thumb'],0).'/'.$imagem;

		if (is_file($arquivo)) 
		  echo "<img src='{$arquivo}' style='border:1px solid #cccccc'>";

		  else 
		   echo 'sem imagem';
	      ?>
	</center>

	</td>
      </tr>



<?php
     $j++;
    }

    $qry->close();
?>
    <tbody>
    </table>

<?php

  }
?>

