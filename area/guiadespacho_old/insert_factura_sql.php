<?php
require_once("../../validatesession_json.php");
require_once("guia_sql.php");

$tra=new cargar_cotizacion();

if($_POST["scliente"]=="")
{
    $salida="nada";
    echo json_encode($salida);
}
{//ejecute en el navegador este script, para ver si se cae, por no tener variables asigfandas,
    //Capturo la fecha de inicio y termino de la cotizacion
    date_default_timezone_set("Chile/Continental");
    //$f1=date("Y-m-d");
    $f1=$_POST["facturacion"];//nuevoclaro
    //$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
    $ffinal=date('Y-m-d', strtotime(str_replace("/","-",$f1)));
    //************************************************************

    //Capturo los datos de los select y contador
    $cliente=$_POST["scliente"];
    $contador=$tra->ObtieneGuia();
    $empresa=$_SESSION['SESS_EMPRESA_ID'];//$_POST["tempresa"];
    $sproyecto=$_POST["sproyecto"];
    $neto=$_POST["neto"];
    $iva=$_POST["iva"];
    $total=$_POST["total"];
    $folio=$_POST["folio"];
    $glosa=$_POST["glosa"];
    $motivo=$_POST["motivo"];
    // nuevos campos
    $rut_chofer=$_POST["rut_chofer"];
    $nom_chofer=$_POST["nom_chofer"];
    $patente=$_POST["patente"];
    $autoriza=$_POST["sautoriza"];

    $idet=$tra->insertar_eguia($contador,$folio,'0',$cliente,$sproyecto,$neto,$iva,'0.19',$total,$ffinal,$empresa,$motivo,$glosa,'pendiente',$rut_chofer,$nom_chofer,$patente,$autoriza);

    $salida = $tra->salida; //si
    //termino de insertar a la table ecotizacion
    //die($idet[0]);

    //ahora inserto los datos a la table de dcotizacion

    //capturo datos del tbl-body

    //los recorro para hacer el insert
    for($i=0;$i<26;$i++)
    {
        if($_POST["codigo"][$i]=="")
        {

        }
        else
        {
        $iva2=$_POST["total_tbl"][$i]*0.19;
        $neto2=$_POST["total_tbl"][$i]-$iva2;
        $proba=$_POST["descripcion"][$i];
        $tra->insertar_dguia($idet[0],$_POST["posicion"][$i],$_POST["codigo"][$i],$proba,$_POST["cantidad"][$i],$_POST["descuento"][$i],$_POST["bodega"][$i],$neto2,$iva2,$_POST["total_tbl"][$i],$empresa);

        }

    }
    //iniciando la forma de pago
    $total1=($total/$fpago);
    $u=1;
    $fpago2=$fpago+1;
    for($e=1;$e<$fpago2;$e++)
    {
        if($e==1)
        {
            $fecha=$ffinal;
            $ffinal2=strtotime ( '+1 month' , strtotime ( $ffinal ) ) ;
            $ffinal2= date ( 'Y-m-d' , $ffinal2 );
            $tra->insertar_pago($idet[0],$e,$total1,$total1,"0",$fecha,$ffinal2,$cliente);
        }
        else
        {
            $fecha=strtotime ( '+'.$u.' month' , strtotime ( $fecha ) ) ;
            $fecha= date ( 'Y-m-d' , $fecha );
            $ffinal2=strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
            $ffinal2= date ( 'Y-m-d' , $ffinal2 );
            $tra->insertar_pago($idet[0],$e,$total1,$total1,"0",$fecha,$ffinal2,$cliente);
        }
    }

    $salida="todo";
    echo json_encode($salida);

//echo json_encode($salida);///de
    //echo $salida;


}

?>
