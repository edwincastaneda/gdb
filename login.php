<?php
include "clases/mysql.php";
$db = new MySQL();

//SESION INICIADA

if(isset($_POST['submit'])){  

$username = $_POST['username'];  
$password = md5($_POST['password']); 

$consulta = $db->consulta("SELECT * FROM usuarios WHERE nombre='".$username."' AND contrasena='".$password."'");
$user = $db->fetch_row($consulta);
if($db->num_rows($consulta)>0){
	
		setcookie("username", $username);  
		setcookie("password", $password);  
		setcookie("id_perfil", $user[3]);  		
		
		header("Location: index.php"); 
	}  
	else {  
		include_once "header.php";
		echo '<div style="margin-top:20px;" class="well well-lg"><b>Contraseña o Usuario Incorrecto</b><br/>';  
		echo 'Haga click <a href="login.php">aquí</a> para intentar nuevamente.</div>'; 
		include_once "footer.php";
	}  
}  
else {  
	if(!isset($_COOKIE['username'])){  
		include_once "header.php";?>
		<div style="margin:50px auto 50px auto;" class="row">
		<h3 class="text-center" style="color:#06A5AA;"><span class="glyphicon glyphicon-off"></span> Iniciar Sesión</h3>
		<form class="form-inline" action="" method="POST">
                <table border=0 style="margin:0 auto;">
                <tr>
                    <td class="text-right">Usuario:&nbsp;</td>
                    <td>
                        <input class="form-control input-sm" type="text" name="username" required="">
                    </td>
                </tr>
                <tr>
                    <td class="text-right">Contraseña:&nbsp;</td>
                    <td>
                        <input class="form-control input-sm" type="password" name="password" required="">
                    </td>
                </tr>
                <tr class="text-right">
                    <td colspan=2 style="padding:10px 0 15px 0;">
                        <input class="btn btn-primary btn-xs" name="submit" type="submit" value="Entrar">
                    </td>
                </tr>
                </table>
                </form>
				</div>
		<?php include_once "footer.php";		
	}  
} 
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){
 header("Location: index.php"); 
} 
?>