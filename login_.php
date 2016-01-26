<?php
	
    require_once("conexion/conexion.php");
    session_cache_limiter ('private, must-revalidate');
	session_cache_expire(1); // in minutes
	
	session_start();
	
	
	
	$errmsg_arr = array();
	$errflag = false;
	
	// function clean($str) {
	// 	$str = @trim($str);
	// 	if(get_magic_quotes_gpc()) {
	// 		$str = stripslashes($str);
	// 	}
	// 	return mysql_real_escape_string(conectar::con(), $str);
	// }
	
	//Sanitize the POST values
	$username = trim($_POST['login']);
	$password = trim($_POST['clave']);
	// Se agrega el campo Empresa
	$empresa = trim($_POST['empresa']);
	$fecha = trim($_POST['fecha']);
	$hora = trim($_POST['hora']);
	$equipo = trim($_POST['equipo']);
	$ip_visita=trim($_POST['ip_visita']);
	$IDSess=session_id();
	
	
	//Input Validations
	if($username == '') {
		$errmsg_arr[] = 'Usuario no valido';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Clave no valida';
		$errflag = true;
	}
	if($empresa =='0'){
		$errmsg_arr[] ='Seleccione una Empresa';
		$errflag = true;
	}
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	$query="SELECT users.IDUser, 
	users.Username, 
	users.Email, 
	users.Name, 
	usuarios_perfiles.Password, 
	perfiles.IDPerfil, 
	perfiles.Nombre as perfilnombre, 
	sucursales.IDSucursal, 
	sucursales.Nombre as sucursalnombre, 
	empresa.RazonSocial
FROM users 
	INNER JOIN usuarios_perfiles ON users.IDUser = usuarios_perfiles.IDUsuario
	 INNER JOIN perfiles ON perfiles.IDPerfil = usuarios_perfiles.IDPerfil
	 INNER JOIN sucursales ON sucursales.IDSucursal = perfiles.IDSucursal
	 INNER JOIN empresa ON sucursales.IDempresa = empresa.IDEmpresa
	where usuarios_perfiles.Password='$password' and users.Username='$username' and sucursales.IDempresa='$empresa'";
	$res = mysql_query($query,conectar::con());
	
	//Check whether the query was successful or not
	if($res) {
		if(mysql_num_rows($res) > 0) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($res);
			$_SESSION['SESS_CONNECTED'] = TRUE;
			$_SESSION['SESS_USER_ID'] = $member['IDUser'];
			$_SESSION['SESS_USERNAME'] = $member['Username'];
			$_SESSION['SESS_PERFILID'] = $member['IDPerfil'];
			$_SESSION['SESS_PERFILNOMBRE'] = $member['perfilnombre'];
			$_SESSION['SESS_SUCURSALID'] = $member['IDSucursal'];
			$_SESSION['SESS_SUCURSALNOMBRE'] = $member['sucursalnombre'];
			$_SESSION['SESS_FECHA'] = $fecha;
			$_SESSION['SESS_HORA']=$hora;
			$_SESSION['SESS_EQUIPO']=$equipo;
			$_SESSION['SESS_IP']=$ip_visita;
			$_SESSION['SESS_EMPRESA_ID']=$empresa;
			//session_id()=$idsession;
			$member['Username']=$User;
						
			//$_SESSION['SESS_LAST_NAME'] = $member['password'];
			//session_write_close();
			$query2="INSERT INTO session (IDSession, sessionid, Username, IDEmpresa,Fecha, Hora, Equipo, fecha_close, hora_close, IP) 
			VALUES (NULL, '$IDSess', '$username', '$empresa','$fecha', '$hora', '$equipo', '0', '0', '$ip_visita')";
			
			$res2 = mysql_query($query2,conectar::con());
			header("location: principal.php");
			exit();
		}else {
			//Login failed
			$_SESSION['SESS_CONNECTED'] = FALSE;
			$errmsg_arr[] = 'usuario y/o password incorrectos !';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				session_write_close();
				header("location: index.php");
				exit();
			}
		}
	}else {
		session_write_close();
		die("Query ha Fallado - Favor Informar");
	}
	
?>
