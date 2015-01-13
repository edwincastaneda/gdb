<?php include ("../header.php"); 
include("../clases/mysql.php");
$db = new MySQL();
$archivo="usuarios.php";
$archivo_ruta="pages/".$archivo;

//SESION INICIADA
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){ 

//PERMISOS PARA VER LA PAGINA
if($db->validaPagina($_COOKIE['id_perfil'],$archivo_ruta)){
    


if(isset($_GET['id'])){
$consultaEdit = $db->consulta("SELECT * FROM usuarios WHERE id=".$_GET['id']);
$edit = $db->fetch_row($consultaEdit);
}
?>


<div class="row">
	<div class="col-md-12">
		<table style="width:100%;">
			<tr>
				<td class="text-left"><h3 class="text-muted">Usuarios</h3></td>
				<td class="text-right"><a id="volver" href="../"><span class="glyphicon glyphicon-log-out"></span> Volver</a></td>
			</tr>
		</table>
	</div>
</div>
<div id="catalogo_form" class="row">
<form method="post" action="ctrl/ctrl_usuarios.php">
<table border=0 style="margin:0 auto; width:100%;">
<tr>
    <td style="width:90px;" class="text-right">#: &nbsp;</td>
	<td>
        <input class="form-control input-sm" type=text name="id" value="<?php if(isset($edit[0])){echo $edit[0];}?>" style="text-align:right;" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Nombre: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="nombre" value="<?php if(isset($edit[1])){echo $edit[1];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Contrase&ntilde;a: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="password" name="contrasena" value="<?php //if(isset($edit[2])){echo $edit[2];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Perfil: &nbsp;</td>
	<td>
		<select style="width:100%;" class="form-control input-sm" name="id_perfil">
		<?php $consulta = $db->consulta("SELECT id, nombre FROM perfiles");
			if($db->num_rows($consulta)>0){
				while($results = $db->fetch_array($consulta)){ 
				if(isset($edit[3])&& $edit[3]==$results[0]){?>
				<option value="<?php echo $results[0];?>" selected><?php echo utf8_encode($results[1]);?></option>
				<?php }else{ ?>
				<option value="<?php echo $results[0];?>"><?php echo utf8_encode($results[1]);?></option>
			<?php }
				}
			}?>
		</select>
	</td>
</tr>
<tr class="text-right">
	<td colspan=2 style="padding:10px 0 15px 0;">
	<?php 
	$botones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,3);
	if(isset($_GET['id'])){
		for($i=0;$i<count($botones);$i++){
		   if($botones[$i]['titulo']!="" && $botones[$i]['nombre']=="actualizar"){
                       echo "<a class='btn btn-xs btn-danger' href='".$archivo."'><span class='glyphicon glyphicon-ban-circle'></span> Cancelar</a> ";	 
                       echo "<button type='submit' class='btn btn-xs btn-success' name='".$botones[$i]['nombre']."'><span class='glyphicon glyphicon-".$botones[$i]['imagen_icono']."'></span> ".utf8_encode($botones[$i]['titulo'])."</button>";
		   }
		}
	?>
	<?php }else{ 
		for($i=0;$i<count($botones);$i++){
		   if($botones[$i]['titulo']!="" && $botones[$i]['nombre']=="guardar"){
                        echo "<button type='submit' class='btn btn-xs btn-primary' name='".$botones[$i]['nombre']."'><span class='glyphicon glyphicon-".$botones[$i]['imagen_icono']."'></span> ".utf8_encode($botones[$i]['titulo'])."</button>";
		   }
		}
	} ?>
	</td>
</tr>
</table>
</form>
</div>


<table class="display datos">
<thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Contraseña</th>
        <th>Perfil</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
<?php $consulta = $db->consulta("SELECT U.id, U.nombre, U.contrasena, P.nombre AS perfil
									FROM usuarios U, perfiles P 
									WHERE U.id_perfil=P.id ");
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
									
if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   echo "<tr><td>".$results['id']."</td>"; 
   echo "<td>".$results['nombre']."</td>"; 
   echo "<td>".$results['contrasena']."</td>"; 
   echo "<td>".utf8_encode($results['perfil'])."</td>";
   echo "<td>";
   for($i=0;$i<count($acciones);$i++){
   	   if($acciones[$i]['titulo']!=""){
			echo "<a class='btn btn-xs btn-primary' href='".$archivo."?id=".$results['id']."'><span class='glyphicon glyphicon-".$acciones[$i]['imagen_icono']."'></span> ".utf8_encode ($acciones[$i]['titulo']); 
	   }
	}
    echo "</td></tr>";
 }
}
 ?>
</tbody>
 </table>
 
<?php
$db->desconectar();
// FIN PERMISOS
}else{

	echo "<div style='margin-top:20px;' class='well well-lg'>No tiene permisos para ver esta página, consulte con el administrador del sistema para resolver este inconveniente. <a href='../'>Regresar</a></div>";
}
// FIN SESION
}else{
	echo "<div style='margin-top:20px;' class='well well-lg'>Debe de iniciar sesión para poder ver este contenido! <a href='../login.php'>Iniciar Sesión</a></div>";
}
?>



<?php include "../footer.php" ?>