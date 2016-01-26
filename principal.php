<?php
require_once("validatesession_html.php");

$_SESSION['SESS_ACTUAL_THEME']="tormesol";
$_SESSION['SESS_JTABLE_THEME']="jqueryui/jtable_jqueryui.css";

?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8"> 
       <meta http-equiv="content-type" content="text/html; charset=UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
       <title>Principal - Sistema de Gestión</title>
       <link href="img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
       <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
       <link rel="stylesheet" href="css/magic-bootstrap.css">
       <link rel="stylesheet" href="css/bootstrap.css"/>
       <link rel="stylesheet" href="css/bootstrap-responsive.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/bootstrap-tooltip.js"></script>       

	<!-- jquery -->
	<script src="scripts/jquery/jquery.js" type="text/javascript"></script>
	<script src="scripts/jquery/jquery-ui.js" type="text/javascript"></script>
	<link  href="scripts/jquery/themes/tormesol/jquery-ui.css" rel="stylesheet" type="text/css" />

 
        <script type="text/javascript" src="js/multinivel.js"></script>
	<link rel="stylesheet" href="css/multinivel.css"/>
	
	<script src="js/fullcode_tabs.js" type="text/javascript"></script>
	
	
      <!--[if gte IE 9]>
	<style type="text/css">
	    .gradient {
	    filter: none;
	 }
	 
       </style>
	<![endif]-->
	
	<style type="text/css">
 
	body{
	    margin: 0px;
	}
 
	a:active,
	a:hover {
	   outline: thin dotted #E8EBED;
	   outline: 5px auto -webkit-focus-ring-color;
	   outline-offset: -2px;
	}
	
	.navbar .brand {
	    color: #FFFFFF;
	    font-size: 20px;
	    font-weight: 200;
	    text-shadow: 0 2px 0 #191818;
	}
	
	.navbar .nav > li > a {
	    color: #FFFFFF;
	    float: none;
	    padding: 5px 10px;
	    text-decoration: none;
	    text-shadow: 0 1px 0 #191818;
	}
	.navbar {
	    overflow: visible;
	    margin-bottom: 0px;
	    *position: relative;
	    *z-index: 2;
	  }
	  .navbar-inner {
	    min-height: 40px;
	    padding-left: 5px;
	    padding-right: 5px;
	    background-color:#102B3D;
	    color:#ffffff;
	    font-family: 'Open Sans';
	    *zoom: 1;
	  }
	  

	  
	  #tabs { }
          #tabs li .ui-icon-close { float: left; margin: 2px; cursor: pointer; }
          #add_tab { cursor: pointer; }
	  
	  
	  .ui-widget-content {
		/*border: 1px solid #e0cfc2;*/
		/*background: #eeeeee url(images/ui-bg_highlight-hard_100_eeeeee_1x100.png) 50% top repeat-x;*/
		background: none repeat scroll 0 0 rgba(248, 248, 248, 0.45);
		color: #1e1b1d;
	    }
	  
	</style>

	
	
    </head>
<body class="ui-widget">
    <!-- incluir menu -->
    
    <?php
	    require_once("menu.php");
    ?>
    <!-- fin menu -->
     <!-- habilita iframe -->
    <!-- <input type="text" value="" id="contador" />
    <button type="button" id="activar">activar</button>
    <button type="button" id="mostrar">mostrar</button>-->
    <input type="hidden" value="1" id="oculto_tab"/>
    <div id='tabs' style="width:100%; height: 1600px;display:inline-block; vertical-align:top;">
		<ul id="tabu">
			<li><a href="#tabs-1">Principal</a></li>
		</ul>
		<div id="tabs-1">
			<iframe src="dashboard.php" width="100%" height="1600px" frameborder="0" scrolling="yes"></iframe>
		</div>
    </div>
     <!--
    <iframe class="" name="frame1" id="frame1" width="100%" height="1200" frameborder="0" scrolling="auto"></iframe>
     <!-- Fin Iframe -->
</body>

 
</html>









