  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="galeria" class="error-validate">Envia alguma imagem/foto</label></li> 
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
  if ($act=='update')
    echo "<input type='hidden' name='item' value='${_GET['item']}'>";
?>

<h1>
<?php 
  if ($act=='insert') echo $var['insert'];
   else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>



    <ol>


	<li>	
	  <label>Categoria *<span class='small'>Categoria da galeria</span></label>
	  <select name='cat_id' id='cat_id' class='required'>
		<option>Selecione</option>
		<?php
		  $sql_marca = "SELECT cat_titulo, cat_id FROM ".TABLE_PREFIX."_categoria WHERE cat_status=1 AND cat_area='Galeria'";
		  $qry_marca = $conn->prepare($sql_marca);
		  $qry_marca->bind_result($nome, $id);
		  $qry_marca->execute();
		 
			  while ($qry_marca->fetch()) {
		?>
		   <option value='<?=$id?>'<?php if ($act=='update' && $val['cat_id']==$id) echo ' selected';?>> <?=$nome?></option>
		<?php } $qry_marca->close(); ?>
	  </select>
	</li>




	<li>	
	  <label>Fotos<span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + fotos</a></span></label>
	  <?php
		  
	    if ($act=='update') {
				  
		    $sql_gal = "SELECT rgi_id,rgi_imagem,rgi_pos FROM ".TABLE_PREFIX."_r_gal_imagem WHERE rgi_gal_id=? AND rgi_imagem IS NOT NULL ORDER BY rgi_pos ASC;"; 

			$item_gal = (int)$_GET['item'];
		    $qr_gal = $conn->prepare($sql_gal);
		    $qr_gal->bind_param('i',$item_gal);
		    $qr_gal->execute();
		    $qr_gal->bind_result($g_id,$g_imagem,$g_pos);
		    $i=0;

		      echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
		      while ($qr_gal->fetch()) {
	  ?>
		<tr id="<?=$g_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small'>
		    [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=<?=$var['path']?>&pre=gal&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
		  </td>

		  <td>

		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
			 <?php 
			 
			    if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
			     echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."'><br/>";

			       else echo "<center>imagem não existe.</center>";
			  ?>
			 </div>
       <?php echo '<span class="min">'.$g_imagem.'</span>'; ?>

		  </td>
		</tr>

	      <?php
		      $i++;	

			}
		   echo '</table><br>';

	       }
	       ?>


		 <div class='divImagem'>
		   <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;" accept="image/*">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>
		 </p>
        </li>


    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
