  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="galeria" class="error-validate">Envia alguma imagem/foto</label></li> 
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="data" class="error-validate">Entre com uma data válida</label></li> 
		<li><label for="resumo" class="error-validate">Você precisa informar algum <b>resumo</b></label></li> 
		<li><label for="texto" class="error-validate">Você precisa informar algum <b>texto</b></label></li> 
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
	  <label>Imagem<span class='small'><!--<a href='javascript:void(0);' class='addImagem' id='min'>adicionar + flyers</a></span>--></label>
	  <?php
		  
	    if ($act=='update') {
				  
		    $sql_gal = "SELECT rcg_id,rcg_imagem,rcg_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_galeria WHERE rcg_${var['pre']}_id=? AND rcg_imagem IS NOT NULL ORDER BY rcg_pos ASC;"; 
		    $qr_gal = $conn->prepare($sql_gal);
		    $qr_gal->bind_param('s',$_GET['item']);
		    $qr_gal->execute();
		    $qr_gal->bind_result($g_id,$g_imagem,$g_pos);
		    $i=0;

		      echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
		      while ($qr_gal->fetch()) {
	  ?>
		<tr id="tr<?=$g_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small'>
		    [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=r_<?=$var['pre']?>_galeria&pre=rcg&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
		  </td>

		  <td>

		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
			 <?php 
			 
			    if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
			     echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."'>";

			       else echo "<center>imagem não existe.</center>";
			  ?>
			 </div>

		  </td>
		</tr>

	      <?php
		      $i++;	

			}
		   echo '</table><br>';

	       }
	       ?>


		 <div class='divImagem'>
		   <input class="galeria <?php if ($act=='insert') echo ' required';?>" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>
		 </p>
        </li>


	<li>	
	  <label>Título *<span class='small'>Digite o título</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>


	<li>
	  <label>Data *<span class='small'>Entre com a data</span></label>
	  <input type='text' id='data' name='data' class='required' value='<?=dateen2pt('-',$val['data'],'/')?>'>
	</li>


	<li>
	  <label>Resumo *<span class='small'>Digite o resumo para a listagem</span></label>
	  <textarea name='resumo' id='resumo' class='required tinymce' cols='80' rows='20'><?=stripslashes($val['resumo'])?></textarea>
	</li>


	<li>
	  <label>Texto *<span class='small'>Digite o texto</span></label>
	  <textarea name='texto' id='texto' class='required tinymce' cols='80' rows='20'><?=stripslashes($val['texto'])?></textarea>
	</li>



    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


