<?php
include("../../clases/mysql.php");
$db = new MySQL();

function asigna_permiso($id_perfil){
$db = new MySQL();
$sql="DELETE from asigna_permisos WHERE id_perfiles=".$id_perfil;
    $consulta = $db->consulta($sql);
    foreach($_POST as $key => $val) {
            if(is_numeric($key)){
            $sql="INSERT INTO asigna_permisos (id_perfiles, id_permisos) VALUES(".$id_perfil.", ".$key.")";
            $consulta = $db->consulta($sql);
            }
    }
}

if(isset($_POST['guardar'])){ 
$sql="INSERT INTO perfiles (nombre, descripcion) VALUES('".utf8_decode($_POST['nombre'])."', '".utf8_decode($_POST['descripcion'])."')";
$consulta = $db->consulta($sql);
header("location: ../perfiles.php");
}

if(isset($_POST['actualizar'])){  
$consulta = $db->consulta("UPDATE perfiles SET nombre='".utf8_decode($_POST['nombre'])."', descripcion='".utf8_decode($_POST['descripcion'])."' WHERE id=".$_POST['id']);
asigna_permiso($_POST['id']);
header("location: ../perfiles.php");
}

$db->desconectar();
?>