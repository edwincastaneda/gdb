<?php include ("../header.php");  
include("../clases/mysql.php");
$db = new MySQL();


$archivo=substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$nombre_pagina=trim(substr($archivo,0,+strrpos($archivo,".")));
$archivo_ruta="pages/".$archivo;

//SESION INICIADA
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){ 

//PERMISOS PARA VER LA PAGINA
if($db->validaPagina($_COOKIE['id_perfil'],$archivo_ruta)){
    

if(isset($_GET['id'])){
$consultaEdit = $db->consulta("SELECT * FROM opciones WHERE id=".$_GET['id']);
$edit = $db->fetch_row($consultaEdit);
}

filtroColumnas(6);
?>


<div class="row">
	<div class="col-md-12">
		<table style="width:100%;">
			<tr>
				<td class="text-left"><h3 class="text-muted"><?php echo $db->getNombrePagina($nombre_pagina);?></h3></td>
				<td class="text-right"><a id="volver" href="../"><span class="glyphicon glyphicon-log-out"></span> Volver</a></td>
			</tr>
		</table>
	</div>
</div>
<div id="catalogo_form" class="row">
<form method=post action="ctrl/ctrl_<?php echo $archivo;?>">
<table border=0 style="margin:0 auto; width:100%;">
<tr>
    <td style="width:115px;" class="text-right">#: &nbsp;</td>
	<td>
        <input class="form-control input-sm" type=text name="id" value="<?php if(isset($edit[0])){echo $edit[0];}?>" style="text-align:right;" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Título: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="titulo" value="<?php if(isset($edit[2])){echo utf8_encode($edit[2]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Nombre: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="nombre" value="<?php if(isset($edit[1])){echo $edit[1];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Ruta de archivo: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="ruta_php" value="<?php if(isset($edit[3])){echo $edit[3];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Imagen/Icono: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="imagen_icono" value="<?php if(isset($edit[6])){echo $edit[6];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Tipo: &nbsp;</td>
	<td>
		<select style="width:100%;" class="form-control input-sm" name="tipo">
		<?php if(isset($edit[4])){?>
			<option value="1" <?php if($edit[4]==1){echo "selected";}?>>Páginas</option>
			<option value="2" <?php if($edit[4]==2){echo "selected";}?>>Acciones</option>
			<option value="3" <?php if($edit[4]==3){echo "selected";}?>>Botón</option>
		<?php }else{?>
			<option value="1">Páginas</option>
			<option value="2">Acciones</option>
			<option value="3">Botón</option>
			
		<?php }?>
		</select>
	</td>
</tr>
<tr>
	<td class="text-right">Descripción: &nbsp;</td>
	<td>
	<textarea class="form-control input-sm" name="descripcion"  required="" ><?php if(isset($edit[5])){echo utf8_encode($edit[5]);}?></textarea>
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

<b>Seleccione las columnas que desea visualizar:</b>
<table class="table" id="catalogo_form">
    <tr>
        <td class="mostrarPermisos">#: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i0" checked="true"></td>
        <td class="mostrarPermisos">Nombre: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i1" checked="true"></td>
        <td class="mostrarPermisos">Título: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i2" checked="true"></td>
        <td class="mostrarPermisos">Ruta de archivo: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i3" checked="true"></td>    
    </tr>
    <tr>
        <td class="mostrarPermisos">Tipo: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i4" checked="true"></td>
        <td class="mostrarPermisos">Imagen/Icono: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i5"></td>
        <td class="mostrarPermisos">Descripción: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i6"></td>  
        <td class="mostrarPermisos"></td>
        <td class="mostrarPermisosCheck"></td>
    </tr>

</table>


<table class="display datos">
<thead>
    <tr>
        <th class="head-0">#</th>
	<th class="head-1">Nombre</th>
        <th class="head-2">Título</th>
        <th class="head-3">Ruta de archivo</th>
        <th class="head-4">Tipo</th>
	<th class="head-5">Imagen/Icono</th>
        <th class="head-6">Descripción</th>
	<th class="head-7">Acciones</th>
    </tr>
</thead>
<tbody>
<?php 
$consulta = $db->consulta("SELECT * FROM opciones");
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);


if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   if($results['tipo']==1){$tipo="Páginas";}
   if($results['tipo']==2){$tipo="Acción";}
   if($results['tipo']==3){$tipo="Botón";}
   echo "<tr><td class='column-0'>".$results['id']."</td>"; 
   echo "<td class='column-1'>".$results['nombre']."</td>"; 
   echo "<td class='column-2'>".utf8_encode($results['titulo'])."</td>"; 
   echo "<td class='column-3 text-left'>".$results['ruta_php']."</td>"; 
   echo "<td class='column-4'>".$tipo."</td>";
   echo "<td class='column-5'>".$results['imagen_icono']."</td>"; 
   echo "<td class='column-6 text-left'>".utf8_encode($results['descripcion'])."</td>"; 
   echo "<td class='column-7'>";
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