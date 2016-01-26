<?php
header('Content-Type: text/html; charset=UTF-8');

      $folio = $_POST['b'];
       
      if(!empty($folio)) {
            comprobar($folio);
      }
       
      function comprobar($b) {
            $con = mysql_connect('localhost','root', 'root');
            mysql_select_db('netcode_poblete', $con);
            $sql = mysql_query("Select * from eguiadespacho_general where Folio = '".$b."'",$con);
            $contar = mysql_num_rows($sql);
             
            if($contar == 0){
                  //echo "<span style='font-weight:bold;color:green;'>Disponible.</span>";
            }else{
                  echo '<script type="text/javascript">alert("Nº de Folio ' . $b . ' coincide con un registro (s) de la Base de Datos");</script>';
            }
      }     
?>
