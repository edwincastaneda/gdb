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
$sql="SELECT * FROM servidores WHERE id=".$_GET['id'];
$consultaEdit = $db->consulta($sql);
$edit = $db->fetch_row($consultaEdit);
}



filtroColumnas(7);
?>
<script type="text/javascript" charset="utf8" src="../libs/scripts.js"></script>


<!-- Modal Facilitadores-->
<div class="modal fade" id="facilitadoresModal" tabindex="-1" role="dialog" aria-labelledby="facilitadoresModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="facilitadoresModalLabel">Facilitadores</h4>
      </div>
      <div class="modal-body">
		<table class="display datos">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Teléfono</th>
				<th>Celular</th>
				<th>Email</th>
				<th>Seleccionar</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if(isset($_GET['id'])){
		$sql="SELECT * FROM servidores WHERE tipo in (1,3) AND id<>".$_GET['id'];
		}else{
		$sql="SELECT * FROM servidores WHERE tipo in (1,3)";
		}
		$consulta = $db->consulta($sql);								
											
		if($db->num_rows($consulta)>0){
		  while($results = $db->fetch_array($consulta)){ 
			echo "<tr>";
			echo "<td>".$results['id']."</td>"; 
			echo "<td>".utf8_encode($results['nombres'])."</td>";
			echo "<td>".utf8_encode($results['apellidos'])."</td>"; 
			echo "<td>".$results['telefono']."</td>"; 
			echo "<td>".$results['celular']."</td>";
			echo "<td>".$results['email']."</td>";
			echo "<td>";
			echo "<a class='btn btn-xs btn-success seleccionar_facilitador'><span class='glyphicon glyphicon-ok'></span>";
			echo "<input type='hidden' value='".$results['id']."|".utf8_encode($results['nombres'])." ".utf8_encode($results['apellidos'])."'/>";
			echo "</a>";
			echo "</td>";
			echo "</tr>";
			}
		 }
		 ?>
		</tbody>
		</table>
      </div>
    </div>
  </div>
</div>


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
    <td style="width:80px;" class="text-right">#: &nbsp;</td>
	<td>
        <input class="form-control input-sm" type=text name="id" value="<?php if(isset($edit[0])){echo $edit[0];}?>" style="text-align:right;" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Nombres: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="nombres" value="<?php if(isset($edit[1])){echo utf8_encode($edit[1]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Apellidos: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="apellidos" value="<?php if(isset($edit[2])){echo utf8_encode($edit[2]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Teléfono: &nbsp;</td>
	<td>
            <input maxlength="8" class="form-control input-sm numeric" placeholder="######## (8 dígitos)" type="text" name="telefono" value="<?php if(isset($edit[3])){echo $edit[3];}?>">
	</td>
</tr>
<tr>
	<td class="text-right">Celular: &nbsp;</td>
	<td>
            <input maxlength="8" class="form-control input-sm numeric" placeholder="######## (8 dígitos)" type="text" name="celular" value="<?php if(isset($edit[4])){echo $edit[4];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Email: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="email" value="<?php if(isset($edit[5])){echo $edit[5];}?>">
	</td>
</tr>
<tr>
	<td class="text-right">Dirección: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="direccion" value="<?php if(isset($edit[6])){echo utf8_encode($edit[6]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Tipo: &nbsp;</td>
	<td>
		<select style="width:100%;" class="form-control input-sm" id="tipo" name="tipo">
		<?php if(isset($edit[7])){?>
			<option value="1" <?php if($edit[7]==1){echo "selected";}?>>Facilitador</option>
			<option value="2" <?php if($edit[7]==2){echo "selected";}?>>Líder</option>
			<option value="3" <?php if($edit[7]==3){echo "selected";}?>>Líder/Facilitador</option>
		<?php }else{?>
			<option value="1">Facilitador</option>
			<option value="2">Líder</option>
			<option value="3">Líder/Facilitador</option>
			
		<?php }?>
		</select>
	</td>
</tr>
<tr id="facilitador">
	<td class="text-right">Facilitador: &nbsp;</td>
	<td>
		<div class="input-group">
			<input type="text" class="form-control input-sm" type="text" id="nombre_facilitador" value="<?php if(isset($edit[8])){echo utf8_encode($db->getNombreFacilitadores($edit[8]));}?>" required="" readonly placeholder="NO SELECCIONADO"/>
			<input type="hidden" id="id_facilitador" name="id_facilitador" value="<?php if(isset($edit[8])){echo $edit[8];}else{ echo "0";}?>"/>
			<span class="input-group-btn">
			  <button class="btn btn-default btn-sm select-modal" type="button" data-toggle="modal" data-target="#facilitadoresModal"><span>&#9660;</span></button>
			</span>
		</div>
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

<ul class="list-group">
  <li class="list-group-item">
<b>Seleccione las columnas que desea visualizar:</b>
</li>
 <li class="list-group-item">
<table class="table" id="catalogo_form">
    <tr>
        <td class="mostrarPermisos">#: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i0" checked="true"></td>
        <td class="mostrarPermisos">Nombres: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i1" checked="true"></td>
        <td class="mostrarPermisos">Apellidos: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i2" checked="true"></td>
        <td class="mostrarPermisos">Teléfono: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i3"></td>
    </tr>
    <tr>
        <td class="mostrarPermisos">Celular: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i4" checked="true"></td>
        <td class="mostrarPermisos">Email: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i5"></td>
        <td class="mostrarPermisos">Dirección: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i6"></td>
        <td class="mostrarPermisos">Tipo: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i7" checked="true"></td>
    </tr>

</table>
</li>
</ul>
<table class="display datos">
<thead>
    <tr>
        <th class="head-0">#</th>
        <th class="head-1">Nombres</th>
        <th class="head-2">Apellidos</th>
		<th class="head-3">Teléfono</th>
        <th class="head-4">Celular</th>
        <th class="head-5">Email</th>
        <th class="head-6">Dirección</th>
        <th class="head-7">Tipo</th>
        <th class="head-8">Acciones</th>
    </tr>
</thead>
<tbody>
<?php 
$sql="SELECT * FROM servidores";
$consulta = $db->consulta($sql);
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
									
if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   if($results['tipo']==1){$tipo="Facilitador";}
   if($results['tipo']==2){$tipo="Líder";}
   if($results['tipo']==3){$tipo="Líder/Facilitador";}
   echo "<tr>";
   echo "<td class='column-0'>".$results['id']."</td>"; 
   echo "<td class='column-1'>".utf8_encode($results['nombres'])."</td>";
   echo "<td class='column-2'>".utf8_encode($results['apellidos'])."</td>"; 
   echo "<td class='column-3'>".$results['telefono']."</td>"; 
   echo "<td class='column-4'>".$results['celular']."</td>";
   echo "<td class='column-5'>".$results['email']."</td>";
   echo "<td class='column-6 text-left'>".utf8_encode($results['direccion'])."</td>";
   echo "<td class='column-7'>".$tipo."</td>";
   echo "<td class='column-8'>";
   for($i=0;$i<count($acciones);$i++){
   	   if($acciones[$i]['titulo']!=""){
			echo "<a class='btn btn-xs btn-primary' href='".$archivo."?id=".$results['id']."'><span class='glyphicon glyphicon-".$acciones[$i]['imagen_icono']."'></span> ".utf8_encode ($acciones[$i]['titulo']); 
	   }
	}
    echo "</td>";
    echo "</tr>";
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