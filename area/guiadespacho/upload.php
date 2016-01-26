<?php
require_once("../../conexion/conexion.php");
//upload.php
$output_dir = "uploads/";

if($_POST["id_1"]=="")
{
	echo "no trae id";
}else
{
	if($_POST["img"]=="uno")
	{
			if(isset($_FILES["fila1"]))
			{
				//Filter the file types , if you want.
				if ($_FILES["fila1"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					//move the uploaded file to uploads folder;
					$query="update eorden set img_vbueno1="."'".$output_dir."uno".$_POST["id_1"].$_FILES["fila1"]["name"]."'"." where  id_orden=".$_POST["id_1"];
					mysql_query($query,conectar::con());
					move_uploaded_file($_FILES["fila1"]["tmp_name"],$output_dir."uno".$_POST["id_1"].$_FILES["fila1"]["name"]);
			 
				 echo "Uploaded File :".$_FILES["fila1"]["name"];
				}
			 
			}
	}elseif($_POST["img"]=="dos")
	{
		if(isset($_FILES["fila1"]))
			{
				//Filter the file types , if you want.
				if ($_FILES["fila1"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					//move the uploaded file to uploads folder;
					$query="update eorden set img_vbueno2="."'".$output_dir."dos".$_POST["id_1"].$_FILES["fila1"]["name"]."'"." where  id_orden=".$_POST["id_1"];
					mysql_query($query,conectar::con());
					move_uploaded_file($_FILES["fila1"]["tmp_name"],$output_dir."dos".$_POST["id_1"]. $_FILES["fila1"]["name"]);
			 
				 echo "Uploaded File :".$_FILES["fila1"]["name"];
				}
			 
			}
	}elseif($_POST["img"]=="tres")
	{
		if(isset($_FILES["fila1"]))
			{
				//Filter the file types , if you want.
				if ($_FILES["fila1"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					//move the uploaded file to uploads folder;
					$query="update eorden set img_vbueno3="."'".$output_dir."tres".$_POST["id_1"].$_FILES["fila1"]["name"]."'"." where  id_orden=".$_POST["id_1"];
					mysql_query($query,conectar::con());
					move_uploaded_file($_FILES["fila1"]["tmp_name"],$output_dir."tres".$_POST["id_1"]. $_FILES["fila1"]["name"]);
			 
				 echo "Uploaded File :".$_FILES["fila1"]["name"];
				}
			 
			}
	}
}
?>