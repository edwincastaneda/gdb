<?php
include("../../clases/mysql.php");
$db = new MySQL();
if(isset($_POST['guardar'])){  
$sql="INSERT INTO servidores (nombres, apellidos, telefono, celular, email, direccion, tipo, id_facilitador) "
        . "VALUES('".utf8_decode($_POST['nombres'])."','".utf8_decode($_POST['apellidos'])."', '".$_POST['telefono']."', '".$_POST['celular']."', '".$_POST['email']."', '".utf8_decode($_POST['direccion'])."', '".$_POST['tipo']."', '".$_POST['id_facilitador']."')";
$consulta = $db->consulta($sql);
header("location: ../servidores.php");
}

if(isset($_POST['actualizar'])){  
$sql="UPDATE servidores SET nombres='".utf8_decode($_POST['nombres'])."', apellidos='".utf8_decode($_POST['apellidos'])."', telefono='".$_POST['telefono']."', celular='".$_POST['celular']."', email='".$_POST['email']."', direccion='".utf8_decode($_POST['direccion'])."', tipo='".$_POST['tipo']."', id_facilitador=".$_POST['id_facilitador']." WHERE id=".$_POST['id'];
$consulta = $db->consulta($sql);
header("location: ../servidores.php");
}

$db->desconectar();
?>