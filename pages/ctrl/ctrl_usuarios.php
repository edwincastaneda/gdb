<?php
include("../../clases/mysql.php");
$db = new MySQL();

if(isset($_POST['guardar'])){ 
$sql="SELECT * FROM usuarios WHERE nombre='".$_POST['nombre']."'";
$existe = $db->consulta($sql);
$existeRes = $db->fetch_row($existe);
    if(isset($existeRes[0])){
        include("../../header.php");
        echo "<div style='margin-top:20px;' class='well well-lg'>El nombre de usuario ya esta en uso, seleccione otro nombre y vuelva a intentarlo.<br/>"
        . "Haga click <a href='../usuarios.php' >aquí</a> para regresar.</div>";
        include("../../footer.php");
        
    }else{
        $sql="INSERT INTO usuarios (nombre, contrasena, id_perfil) VALUES('".$_POST['nombre']."', '".md5($_POST['contrasena'])."', ".$_POST['id_perfil'].")";
        $consulta = $db->consulta($sql);
        header("location: ../usuarios.php");
    }
}

if(isset($_POST['actualizar'])){
	if($_POST['contrasena']!=""){
    $sql="UPDATE usuarios SET nombre='".$_POST['nombre']."', contrasena='".md5($_POST['contrasena'])."', id_perfil=".$_POST['id_perfil']." WHERE id=".$_POST['id']; 
	}else{
	$sql="UPDATE usuarios SET nombre='".$_POST['nombre']."', id_perfil=".$_POST['id_perfil']." WHERE id=".$_POST['id']; 
    }
	$consulta = $db->consulta($sql);
    header("location: ../usuarios.php");
}

$db->desconectar();
?>