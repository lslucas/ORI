<?php
 #define o charset padrão do php
 ini_set('default_charset','utf-8'); 

 //define fusohorario padrao
 date_default_timezone_set('America/Sao_Paulo');

# EMAILS
########
 define('EMAIL','contato@ori.com.br');
 //define('EMAIL','bruno@phocus.com.br');
 define('EMAIL_NAME','ORI');
 define('BBC1_EMAIL',EMAIL);
 define('BBC2_EMAIL','');
 define('BBC3_EMAIL','');
 define('BBC4_EMAIL','');
 define('BBC1_NOME','KIKO');
 define('BBC2_NOME','');
 define('BBC3_NOME','');
 define('BBC4_NOME','');
 define('ADM_EMAIL','lslucas@gmail.com');


# CONEXAO COM DB
################

 if ($_SERVER['HTTP_HOST']=='localhost') {
 define('DB_SERVER','localhost');
 define('DB_USER','root');
 define('DB_PASS','');
 define('DB_DATABASE','ori');

 error_reporting(E_ALL);
 ini_set('display_errors','On');
 
 } else {
 define('DB_SERVER','marcandohora.db.8229398.hostedresource.com');
 define('DB_USER','marcandohora');
 define('DB_PASS','mvdbt9MH@');
 define('DB_DATABASE','marcandohora');

 ini_set('display_errors','Off');

 }
#prefixo das tabelas
 define('TABLE_PREFIX','ori'); 


# VARIAVEIS DE CONTROLE
#######################
# variavel que define a raiz do back-end
 if ($_SERVER['HTTP_HOST']=='localhost')
  $host = 'http://localhost/';

  else
   $host = 'http://'.$_SERVER['HTTP_HOST'].'/';

 $path = 'admin';
 $base = $host.$path.'/';


#rp relative path, caminho relativo para a raiz do back-end
 if (@!file_exists('inc.header.php')) {
   if (@file_exists('../inc.header.php')) $rp = '../';
   if (@file_exists('../../inc.header.php')) $rp = '../../';

 } else $rp = '';




# VARIAVEIS GLOBAIS
###################

 define('SITE_NAME','ORI');
 if ($_SERVER['HTTP_HOST']=='localhost') define('SITE_URL','http://localhost/ori/');
 else define('SITE_URL','http://www.ori.com/');
 $SITE_URL = SITE_URL;
 define('RODAPE','<a href="'.SITE_URL.'">'.SITE_NAME.'</a>');

 define('SITE_ADM_IMGPATH','images');
 define('FILE_LOGO','logo.jpg');
 define('SITE_ADMLOGO','<img src="'.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');
 define('URL_ADMLOGO','<img src="'.SITE_URL.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');

 define('PATH_FILE',$rp.'../upload');
 define('PATH_IMG',$rp.'../images');

# DEBUG
#######

 define('DEBUG',0);
 define('DEBUG_LOG',$rp.'debug.log');





# variavel que define o path
 $p  = isset($_GET['p'])?$_GET['p']:'';
# actual path, o local atual no sistema
 $ap = !empty($p)?$rp.$p.'/':'';
# se esta dentro de um modulo verifica ql o status, insert/update ou nenhum
 if(isset($_GET['insert']))
  $act = 'insert';
  elseif(isset($_GET['update']))
   $act='update';
   else 
    $act='';

#|,forecolor,backcolor,image,
## TINYMCE BBCODE
$TinyMCE = <<<end
   forced_root_block : false,
   force_br_newlines : true,
   force_p_newlines : false,

	script_url : "${rp}js/tinymce/jscripts/tiny_mce/tiny_mce.js",
	mode : "exact",
	theme : "advanced",
	skin_variant : "silver",
	plugins : "legacyoutput,safari,iespell,contextmenu,paste,directionality,noneditable,visualchars,xhtmlxtras,template,inlinepopups,nonbreaking",

	onchange_callback: function(editor) {
		tinyMCE.triggerSave();
		$("#" + editor.id).valid();
	},


    inline_styles : false,
    paste_auto_cleanup_on_paste: true,
    paste_convert_headers_to_strong : true,
    convert_fonts_to_spans : false,

    valid_elements : ""
    +"a[href|target],"
    +"b,"
    +"br,"
    +"font[color|face|size|style],"
    +"span[class|align|style],"
    +"img[src|id|width|height|align|hspace|vspace],"
    +"i,"
    +"li,"
    +"p[align|class],"
    +"h1,"
    +"h2,"
    +"h3,"
    +"h4,"
    +"h5,"
    +"h6,"
    +"textformat[blockindent|indent|leading|leftmargin|rightmargin|tabstops],"
    +"u",


	// Theme options
	theme_advanced_buttons1 : "bold,italic,|,paste,pastetext,pasteword,|,undo,redo,|,link,unlink,|,removeformat,cleanup",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : true,
	content_css : "${rp}css/tinymce.css"

end;

//"a[href|target=_blank],strong/b,div[align],br," +"basefont[color|face|id|size],"
#HTML DO EMAIL DO ADMINISTRADOR
$SITE_NAME = SITE_NAME;
$administrador_email_header = <<<end
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>$SITE_NAME</title>
<style type='text/css'>
  <!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-size: 12px;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;

} h1,h2,h3,h4,h5 {
	color: #145675;
	font-weight: bolder;
	font-size: 12pt;

} a {
 color: #145675;
 background-color: transparent;
 text-decoration: none;
 font-weight: normal;

} a:visited {
 color: #036EBF;
 text-decoration: none;

} a:hover {
 color: #78251B;
 background-color: #d0baba;
 text-decoration: none;
} .central {
 width:450px;
 margin:20px;
}
}-->
  </style>

</head>
<body>
<div class="central">
 <h3>$SITE_NAME</h3>
end;

$administrador_email_footer = <<<end
</div>
</body>
</html>

end;
?>
