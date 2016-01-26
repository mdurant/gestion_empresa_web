<?php

try {

	//echo json_encode($_ENV);
	/*
	$xml = new SimpleXMLElement('<root/>');
	array_walk_recursive($GLOBALS, array ($xml, 'addChild'));
	print $xml->asXML();/**/
	
	
	//die;
	
	
	
	require_once("conexion/funciones.php");
	$func = new funciones();
	$ip_real=$func->getRealIP();
	$emp = $func->cargaEmpresas();
	
	
	// function get_revision() {
	// 	return @shell_exec('svnversion -c');
	// }
	
	
	
	  session_start();
	  
	  $_SESSION['SESS_ROOTFOLDER']="";
	  
	  $_SESSION['SESS_INDEXPAGE'] = $_SERVER['REQUEST_URI']; //substr( __FILE__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
	
	  //echo $_SESSION['SESS_INDEXPAGE'];
	  
	  $_SESSION['SESS_VERSION']="1.3.12";
	  
	  //Unset the variables stored in session
	  /*unset($_SESSION['SESS_USER_ID']);
	  unset($_SESSION['SESS_USERNAME']);
	/**/
	  //unset($_SESSION['SE']);
  
  
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Gestión Administrativa - Software On Line">
<meta name="author" content="Netcode Osorno">
<title>SISTEMA | Login Gestión Administrativa</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="js/bootstrap.js" type="text/javascript"></script>
<link href="css/bootstrap.css" type="text/css" rel="stylesheet">
<style type="text/css">
	
body {  
  
  -webkit-background-size:cover;
  background:url(img/bg1.jpg) 50% 50% / cover no-repeat fixed;
  color:#393939;
  font-family:'Open Sans';
  font-size:14px;
  height:100%;
  margin:0;
  padding:0;
  
  
  


}	
h1, h2, h3 {
    margin-bottom: 10px;
    margin-top: 15px;
}	
.logo{
    margin: 60px auto 0;
    padding: 15px;
    text-align: center;

	}
.contenido{
    background: url("img/bg-white-lock.png") repeat scroll 0 0 transparent;
    margin: 0 auto;

    z-index:3;
    border-radius: 6px 6px 6px 6px;
}
.form-title{
    font-family:'Open Sans';
    font-size:20px;
    line-height:120%;
    font-weight:bold;
    color:rgb(255,255,255);
    text-align:left;
    text-shadow:1px 1px 2px rgba(0,0,0,0.9);

    }
h3{
    color:#FFF;
    }
.titulo{
	text-align: center;
        color: #D4E8EE;
	font-family:'Open Sans';
        font-size:14px;
	}
.footer{
    z-index:2;
    /*background: rgb(181,12,19);*/
    width:100%;
    height: 300px;
}
h4{
    font-size:11px;
    text-align: center;
    color: #D4E8EE;
}
</style>
</head>

<body >
    <div class="logo">
	<img src="img/logo.png" width="190" height="145">
    </div>
    <div class="titulo">
	DEMO WEB | Sistema de Gestión Administrativo
    </div>
    
    <div style="height: 5px;width: 100%;"></div>
    <div style="width: 320px" class="container contenido">

      <form class="form-signin" method="post" action="login_.php" novalidate="novalidate">
        <h2 class="form-signin-heading">Accede a tu cuenta</h2>
	
	<?php
	 if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
	 echo '<ul class="err">';
	 foreach($_SESSION['ERRMSG_ARR'] as $msg) {
	   echo '<li>',$msg,'</li>'; 
	   }
	 echo '</ul>';
	 unset($_SESSION['ERRMSG_ARR']);
	 }
        ?>
	<?php date_default_timezone_set("Chile/Continental");?>
	
	<input name="login" id="login" type="text" autofocus="" placeholder="Usuario" class="form-control" required autocomplete="off">
        <input name="clave" id="clave" type="password" placeholder="Contraseña" class="form-control" required autocomplete="off">
	<select name="empresa" id="empresa" class="form-control" required>
	<option value="0">-Seleccione</option>
	<?php
		for ($e=0;$e<sizeof($emp);$e++){
	?>
		<option value="<?=$emp[$e]["IDEmpresa"]?>"><?=$emp[$e]["RazonSocial"]?></option>
	<?php
		}
	?>	
        </select>
	<div style="height: 5px;width: 100%;"></div>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Entrar</button>
	<div style="height: 5px;width: 100%;"></div>
      </form>

    </div>

    <h4>Versión  <?=$_SESSION['SESS_VERSION']?></h4>
    <h4>Desarrollado por NETCODE </h4>
    <h4>San Antonio 19 Oficina 907 - Santiago Chile</h4>
    <div class="footer">
        
    </div>
</body>
</html>

