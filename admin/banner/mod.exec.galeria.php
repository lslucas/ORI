

<?php
 if (isset($_FILES)) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;


       if (isset($_FILES['imagem']['name']) && is_file($_FILES['imagem']['tmp_name']) ) {


	 $filename = $res['item'].'_'.rand();
	 $handle = new Upload($_FILES['imagem']);

	 if ($handle->uploaded) {
	   $handle->file_new_name_body  = $filename;
	   $handle->Process($var['path_original']);
	   if (!$handle->processed) echo 'error : ' . $handle->error;

	   $handle->file_new_name_body  = $filename;
	   $handle->image_resize        = true;
	   $handle->image_ratio_y       = true;
	   $handle->image_x             = $var['imagemWidth'];
	   $handle->image_y             = $var['imagemHeight'];
	   $handle->process($var['path_imagem']);
	   if (!$handle->processed) echo 'error : ' . $handle->error;

	   $handle->file_new_name_body  = $filename;
	   $handle->image_resize        = true;
	   $handle->image_ratio_y       = true;
	   $handle->image_x             = $var['thumbWidth'];
	   $handle->image_y             = $var['thumbHeight'];
	   $handle->process($var['path_thumb']);
	   if (!$handle->processed) echo 'error : ' . $handle->error;


	        $imagem = $handle->file_dst_name;
		$sql_img = "UPDATE ".TABLE_PREFIX."_${var['table']} 
				SET ${var['pre']}_imagem='${imagem}'
			    WHERE
		    	     ${var['pre']}_id=".$res['item'];
		$qry_img = $conn->query($sql_img);
		#$qry_img->close();


         }
      }


 }
?>
