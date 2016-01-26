<?php
require_once("../../conexion/conexion.php");
$salida='';
			   
$id=$_GET["plantilla"];
$contador=0;
$contador2=1;
$query=<<<QUERY
		SELECT
dplantillacot.id_dplantilla_cot,
dplantillacot.id_eplantilla_cot,
dplantillacot.cantidad,
dplantillacot.descuento,
dplantillacot.descripcion,
dplantillacot.codigo,
dplantillacot.Neto,
dplantillacot.Iva,
dplantillacot.Total,
dplantillacot.almacen,
dplantillacot.posicion
FROM
dplantillacot
WHERE id_eplantilla_cot="$id"
QUERY;

$res=mysql_query($query,Conectar::con());
while($row=mysql_fetch_assoc($res))
{
	$salida.='<tbody>				
            <tr>
					<td width="50px;"><center><input style="border:none; width:100%;"  type="text" disabled name="posicion[]" id="" value="'.($contador2++*10).'" class="act  form-control input-sm"/></center></td>
					<td width="113px;"><center>
					<table style="width: 100%">
						<TR>
							 <TD tyle="width: 90%"><input style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="'.$row["codigo"].'" class="form-control input-sm caja_cod cod cod_complete"/></TD>
							 <TD><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
								<span class="glyphicon glyphicon-search"></span>
								</button></TD>
						</TR>
						</table>
					</center></td>
					<td width="170px;">
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%">
								<textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm act" id="descri" name="descripcion[]" cols="20" rows="1" >'.$row["descripcion"].'</textarea>
							 </TD>
							 <TD style="width: 10%">
								<button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" >
								<span class="glyphicon glyphicon-pencil"></span>
								</button></TD>
						</TR>
						</table>
					</td>
					<td width="81px;"><center><input style="border:none; width: 100%;"  type="text" name="cantidad[]"  maxlength="7" id="cantidad" value="'.$row["cantidad"].'" class="cant form-control input-sm act cantidad"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="bodega[]"  id="" value="'.$row["almacen"].'" class="form-control input-sm act"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="descuento[]"  id="" value="'.$row["descuento"].'" class="desc form-control input-sm act descuento"/></center></td>
					<td width="81px;"><center><input type="text" style="border:none;width: 100%;" class="precio_unitario form-control input-sm  act precio_unitario" name="precio_unitario[]" id="precio_unitario"  value="'.$row["Neto"].'"/></center></td>
					<td width="81px;"><center><input type="text" class="total act form-control input-sm total_tbl " style="border:none;" name="total_tbl[]" id="total_tbl" disabled  value="'.$row["Total"].'"/></center></td>
				    <td id="preciounitario" style="display:none">'.$row["Neto"].'</td>
					<td id="preciototal" class="total" style="display:none">'.$row["Total"].'</td>
					<td id="totalstock" style="display:none">'.$row["cantidad"].'</td>
                    <td style="display:none;"><input type="hidden" value="'.$row["id_dplantilla_cot"].'" name="id_detalles[]" id="id_detalles"/></td>
                    	<td style="width: 3%">

							<button style="width: 100%" id="btn-quitar" class="btn btn-default btn-sm ui-corner-all btn-quitar" type="button" >
							<span class="glyphicon glyphicon-trash"></span>
							</button>

					</td>
                </tr>
         </tbody>';
                
                
               
				
                $contador++;
                $contador_final=26-$contador;
}


			$e=0;
			for($i=1;$i<$contador_final;$i++)
			{				
			$salida.='
         <tbody>				
            <tr>
					<td width="50px;"><center><input style="border:none; width:100%;"  type="text" disabled name="posicion[]" id="" value="'.($contador2++*10).'" class="act  form-control input-sm"/></center></td>
					<td width="113px;"><center>
					<table style="width: 100%">
						<TR>
							 <TD tyle="width: 90%"><input style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="" class="form-control input-sm caja_cod cod cod_complete"/></TD>
							 <TD><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
								<span class="glyphicon glyphicon-search"></span>
								</button></TD>
						</TR>
						</table>
					</center></td>
					<td width="170px;">
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%">
								<textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm act" id="descri" name="descripcion[]" cols="20" rows="1" ></textarea>
								<!--<input style="border:none;width: 100%;"  type="text" name="descripcion[]"  id="descri" value="" class="form-control input-sm span2 act"/>-->
							 </TD>
							 <TD style="width: 10%">
								<button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" >
								<span class="glyphicon glyphicon-pencil"></span>
								</button></TD>
						</TR>
						</table>
					</td>
					<td width="81px;"><center><input style="border:none; width: 100%;"  type="text" name="cantidad[]" disabled maxlength="7" id="cantidad" value="" class="cant form-control input-sm act cantidad"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="bodega[]" disabled id="" value="" class="form-control input-sm act"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="descuento[]" disabled id="" value="" class="desc form-control input-sm act descuento"/></center></td>
					<td width="81px;"><center><input type="text" style="border:none;width: 100%;" class="precio_unitario form-control input-sm  act precio_unitario" name="precio_unitario[]" id="precio_unitario" disabled value=""/></center></td>
					<td width="81px;"><center><input type="text" class="total act form-control input-sm total_tbl " style="border:none;" name="total_tbl[]" id="total_tbl" disabled  value=""/></center></td>
				    <td id="preciounitario" style="display:none"></td>
					<td id="preciototal" class="total" style="display:none"></td>
					<td id="totalstock" style="display:none"></td>
                    <td style="display:none;"><input type="hidden" value="" name="id_detalles[]" id="id_detalles"/></td>
                    	<td style="width: 3%">

							<button style="width: 100%" id="btn-quitar" class="btn btn-default btn-sm ui-corner-all btn-quitar" type="button" >
							<span class="glyphicon glyphicon-trash"></span>
							</button>

					</td>
                </tr>
         </tbody>
                ';
           
			}
			
            
      $query2="select * from dplantillacot where id_eplantilla_cot='$id'"; 
      $res2=mysql_query($query2,conectar::con());
      
      while($row2=mysql_fetch_assoc($res2))
      {
            $neto=$row2["Neto"];
            $iva=$row2["Iva"];
            $total=$row2["Total"];
      } 

            $salidas=array("sale"=>$salida,"Neto"=>$neto,"Iva"=>$iva,"Total"=>$total);
			
		echo json_encode($salidas);
?>