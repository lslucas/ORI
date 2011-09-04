  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="nome" class="error-validate">Digite o nome</label></li> 
		<li><label for="email" class="error-validate">Tem que informar o email</label></li> 
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


<!--
	<li>	
	  <label>Nome *<span class='small'>Nome do cadastrado</span></label>
	  <input type='text' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>
-->


	<li>	
	  <label>E-mail *<span class='small'>Digite o e-mail</span></label>
	  <input type='text' name='email' id='email' class='required email' value='<?=$val['email']?>'>
	</li>

    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


