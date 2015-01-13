<?php
include("../../clases/mysql.php");
$db = new MySQL();
if(isset($_POST['guardar'])){ 
echo $sql="INSERT INTO opciones (nombre, titulo, ruta_php, tipo, descripcion, imagen_icono) VALUES('".$_POST['nombre']."','".utf8_decode($_POST['titulo'])."', '".urldecode($_POST['ruta_php'])."', '".$_POST['tipo']."', '".utf8_decode($_POST['descripcion'])."', '".urldecode($_POST['imagen_icono'])."')";
$consulta = $db->consulta($sql);
header("location: ../opciones.php");
}

if(isset($_POST['actualizar'])){  
$consulta = $db->consulta("UPDATE opciones SET titulo='".utf8_decode($_POST['titulo'])."', nombre='".$_POST['nombre']."', ruta_php='".urldecode($_POST['ruta_php'])."', tipo='".$_POST['tipo']."', descripcion='".utf8_decode($_POST['descripcion'])."', imagen_icono='".urldecode($_POST['imagen_icono'])."' WHERE id=".$_POST['id']);
header("location: ../opciones.php");
}

$db->desconectar();
?>