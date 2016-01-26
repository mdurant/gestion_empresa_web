<?php
    session_start();
    
    if(!isset($_SESSION['SESS_CONNECTED']) || ($_SESSION['SESS_CONNECTED'] == FALSE)) {
        
        $Result = array();
        $Result['Result'] = "ERROR";
        $Result['Message']= "La sesión ha caducado. Ingrese nuevamente.";

        
        print json_encode($Result);
        die;

    }
    

     
?>