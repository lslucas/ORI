<?php


   $sql_dmod = "DELETE FROM ".TABLE_PREFIX."_r_cad_perfil WHERE rcp_cad_id=?";
   $qry_dmod = $conn->prepare($sql_dmod);
   $qry_dmod->bind_param('i', $res['item']); 
   $qry_dmod->execute();
   $qry_dmod->close();


   if(isset($_POST['perfil'])) {

	   $sql_prin = "INSERT INTO ".TABLE_PREFIX."_r_cad_perfil (rcp_cad_id, rcp_cat_id) VALUES (?, ?)";
	   $qry_prin = $conn->prepare($sql_prin);

	   $area = 1;

	   for ($i=0;$i<count($_POST['perfil']);$i++) {

		  $qry_prin->bind_param("ii", $res['item'], $_POST['perfil'][$i]);
		  $qry_prin->execute();

	   }

	   $qry_prin->close();

   }
