<?php
include("../../clases/mysql.php");
$db = new MySQL();
if(isset($_POST['guardar'])){  
$sql="INSERT INTO grupos (id_facilitador, id_lider, anfitrion, direccion, telefono, dia, hora_inicia, hora_finaliza, directrices, transporte)"
        ." VALUES(".$_POST['id_facilitador'].", ".$_POST['id_lider'].", '".utf8_decode($_POST['anfitrion'])."', '".utf8_decode($_POST['direccion'])."', '".$_POST['telefono']."', '".utf8_decode($_POST['dia'])."', '".$_POST['hora_inicia']."', '".$_POST['hora_finaliza']."', '".utf8_decode($_POST['directrices'])."', '".utf8_decode($_POST['transporte'])."')";
$consulta = $db->consulta($sql);
header("location: ../grupos.php");
}

if(isset($_POST['actualizar'])){  
echo $sql="UPDATE grupos SET id_facilitador=".$_POST['id_facilitador'].", id_lider=".$_POST['id_lider'].", anfitrion='".utf8_decode($_POST['anfitrion'])."', direccion='".utf8_decode($_POST['direccion'])."', telefono='".$_POST['telefono']."', dia='".utf8_decode($_POST['dia'])."', hora_inicia='".$_POST['hora_inicia']."', hora_finaliza='".$_POST['hora_finaliza']."', directrices='".utf8_decode($_POST['directrices'])."', transporte='".utf8_decode($_POST['transporte'])."' WHERE id=".$_POST['id'];
$consulta = $db->consulta($sql);
header("location: ../grupos.php");
}

$db->desconectar();
?>