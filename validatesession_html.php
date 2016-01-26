<?php
session_start();

    
    if(!isset($_SESSION['SESS_CONNECTED']) || ($_SESSION['SESS_CONNECTED'] == FALSE)) {
        
        // modificaciones Mauricio
        // 22/10/2014
        header('Content-Type: text/html; charset=UTF-8');
        echo "<div class='rectangulo_mensaje'>
                <br>
                <span class='titulo'>Sesión Expirada </span><br>
                Para volver al sistema, es necesario volver a ingresar <br>
                <a href='http://inoxpoblete.netcode.cl'>Loguearse</a>
                </div>";
      /*  
        echo "La sesión ha caducado. Ingrese nuevamente.";
        echo "<br>";
        echo "<a href='http://sistema.netcode.cl'>Loguearse</a>";
       */ 
        exit();
        
        die;
    }
    

     
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Gestión Administrativa - Software On Line">
<meta name="author" content="Netcode Osorno">
<title>Sistema Gestión Administrativo</title>
<style type="text/css">
    
    body{
        font-family: Verdana, Tahoma, Lucida sans-serif Unicode;
        font-size:11px;
        
    }
    .rectangulo_mensaje{
        width: 300px;
        height: 250px;
        background-color: rgb();
        
    }
    .titulo{
        font-weight: bold;
    }
</style>
</html>
