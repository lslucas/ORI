<?php

  include_once '../_inc/global.php';
  include_once '../_inc/db.php';
  include_once '../_inc/global_function.php';




   /*
    *pega o nome da festa e verifica se ela existe
    */
   $sql_cad = "SELECT cad_nome,cad_email, cad_status, DATE_FORMAT(cad_timestamp, '%d/%m/%Y') data FROM ".TABLE_PREFIX."_cadastro 
               WHERE cad_email IS NOT NULL ORDER BY cad_email";
   if ($qry_cad = $conn->prepare($sql_cad)){

     $qry_cad->execute();
     $qry_cad->store_result();
     $qry_cad->bind_result($cad_nome,$cad_email,$cad_status, $cad_data);
     $num = $qry_cad->num_rows;

   } else echo $qry_cad->error;




   if($num==0)
     die('Nenhum cadastro');

   else {


      function cleanData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        return html_entity_decode($str);
      }

      # file name for download
      $filename = "cadastros_".date('Ymd').".xls";

      header("Content-Disposition: attachment; filename=\"$filename\"");
      header("Content-Type: application/vnd.ms-excel");


       $flag=false;
          $arrNome = $arrData = $arrEmail = $arrStatus = '';
          while($qry_cad->fetch()){

            $arrNome .= $cad_nome.',';
            $arrEmail .= $cad_email.',';
            $arrData .= $cad_data.',';
            $arrStatus .= ($cad_status==1)?'ativo':'inativo';
            $arrStatus .= ',';

          }

        $qry_cad->close();


        /*
         *cabeçalho dos dados
         */
        $row = array('nome'=>explode(',',substr($arrNome,0,-1)),
                      'email'=>explode(',',substr($arrEmail,0,-1)),
                      'data'=>explode(',',substr($arrData,0,-1)),
                      'status'=>explode(',',substr($arrStatus,0,-1)),
                    );




          if($num>0) {

              if(!$flag) {
                # display field/column names as first row
                echo "Lista de Cadastros\n";
                echo "Gerado em ".date('d/m/Y H:i')."\n\n";
                //echo "Nome\t";
                echo "E-mail\t";
                echo "Data de Cadastro na Lista\t";
                echo "Status\t";
                echo "\n";
                $flag = true;
              }



              for($i=0;$i<count($row['nome']);$i++){
                //echo cleanData($row['nome'][$i])."\t";
                echo cleanData($row['email'][$i])."\t";
                echo cleanData($row['data'][$i])."\t";
                echo cleanData($row['status'][$i])."\t";
                echo "\n";

              }

          }



   }
