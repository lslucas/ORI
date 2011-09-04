<?php
#INICIO MSG ERROS
################
# ERRO DUBPLICADO
$nomeAcao = $act=='insert'?'incluido':'alterado';


$msgDuplicado = <<<end

 <p class='error'>Já existe $var[um] com o título <b>- $res[titulo] -</b></p>
 <br>
 <p align='center'>
  <a href='?p=$p&insert'>Volte e preencha novamente</a> - <a href='?p=$p'>Ir para a listagem</a>
 </p>

end;
# ERRO CONSULTA
$msgErro = <<<end

 <p class='error'>Houve um erro!</p>
 <br>
 <pre>$conn->error()</pre>

end;
# SUCESSO CONSULTA
$msgSucesso = <<<end

 <p class='success'>Ítem $nomeAcao com êxito!</p>
 <br>
 <p align='center'>
  <a href='?p=$p&insert'>Incluir $var[novo]</a> - <a href='?p=$p'>Ir para a listagem</a>
 </p>

end;
##/FIM MSG ERROS
################
?>
