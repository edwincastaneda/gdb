<?php
include("../../clases/mysql.php");
$db = new MySQL();
if(isset($_POST['guardar'])){  
$sql="INSERT INTO registrar_actividad (id_grupo, fecha, asistentes, invitados, salvos, ofrenda)"
        ." VALUES(".$_POST['id_grupo'].", '".$_POST['fecha']."', ".$_POST['asistentes'].", ".$_POST['invitados'].", ".$_POST['salvos'].", ".$_POST['ofrenda'].")";
$consulta = $db->consulta($sql);
header("location: ../registrar-actividad.php");
}

if(isset($_POST['actualizar'])){  
$sql="UPDATE registrar_actividad SET id_grupo=".$_POST['id_grupo'].", fecha='".$_POST['fecha']."', asistentes=".$_POST['asistentes'].", invitados=".$_POST['invitados'].", salvos=".$_POST['salvos'].", ofrenda=".$_POST['ofrenda']." WHERE id=".$_POST['id'];
$consulta = $db->consulta($sql);
header("location: ../registrar-actividad.php");
}

$db->desconectar();
?>