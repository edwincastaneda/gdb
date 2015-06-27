<?php
include("../../clases/mysql.php");
$db = new MySQL();

if(isset($_POST['guardar'])){ 
$sql="SELECT * FROM tipos_grupos WHERE nombre='".$_POST['nombre']."'";
$existe = $db->consulta($sql);
$existeRes = $db->fetch_row($existe);
    if(isset($existeRes[0])){
        include("../../header.php");
        echo "<div style='margin-top:20px;' class='well well-lg'>El nombre de grupo ya existe, ingrese otro nombre y vuelva a intentarlo.<br/>"
        . "Haga click <a href='../tipos_grupos.php' >aquí</a> para regresar.</div>";
        include("../../footer.php");
        
    }else{
        $sql="INSERT INTO tipos_grupos (nombre) VALUES('".utf8_decode($_POST['nombre'])."')";
        $consulta = $db->consulta($sql);
        header("location: ../tipos_grupos.php");
    }
}

if(isset($_POST['actualizar'])){
    $sql="UPDATE tipos_grupos SET nombre='".utf8_decode($_POST['nombre'])."' WHERE id=".$_POST['id']; 
    $consulta = $db->consulta($sql);
    header("location: ../tipos_grupos.php");
}

$db->desconectar();
?>