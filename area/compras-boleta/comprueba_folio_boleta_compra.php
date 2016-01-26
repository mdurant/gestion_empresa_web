<?php
header('Content-Type: text/html; charset=UTF-8');

      $folio = $_POST['b'];
       
      if(!empty($folio)) {
            comprobar($folio);
      }
       
      function comprobar($b) {
            $con = mysql_connect('localhost','cne9836_userinox', '1q2w3e4r5t6y');
            mysql_select_db('cne9836_poblete', $con);
            $sql = mysql_query("Select * from eboleta where folio_boleta = '".$b."'",$con);
            $contar = mysql_num_rows($sql);
             
            if($contar == 0){
                  //echo "<span style='font-weight:bold;color:green;'>Disponible.</span>";
            }else{
                  echo '<script type="text/javascript">alert("Nº de Folio ' . $b . ' coincide con un registro (s) de la Base de Datos");</script>';
            }
      }     
?>
