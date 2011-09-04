  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="imagem" class="error-validate">Insira uma imagem</label></li> 
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
	  <label>Imagem *</label>
	      <?php

	       if($act=='update' && !empty($val['imagem'])) { 

	      ?>

	   [<a href='?p=<?=$p?>&delete_galeria&item=<?=$_GET['item']?>&prefix=<?=$var['path']?>&pre=<?=$var['pre']?>&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$_GET['item']?>">remover</a>]

	   <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>


		    <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
		    <?php 
		    
		       $img = $val['imagem'];
		       if (file_exists(substr($var['path_thumb'],0)."/".$img))
			echo "<img src='".substr($var['path_thumb'],0)."/".$img."'>";

			  else echo "<center>imagem não existe.</center>";
		     ?>
		    </div>

	      <?php

	       } else {

	      ?>

		 <div class='divImagem'>
		   <input class="required" type='file' name='imagem' id='imagem' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
		 </div>

	      <?php

	       }

	      ?>


		 </p>
        </li>


    </ol>





    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
