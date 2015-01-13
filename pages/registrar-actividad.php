<?php include ("../header.php"); 
include("../clases/mysql.php");
$db = new MySQL();
$archivo="registrar-actividad.php";
$archivo_ruta="pages/".$archivo;

//SESION INICIADA
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){ 

//PERMISOS PARA VER LA PAGINA
if($db->validaPagina($_COOKIE['id_perfil'],$archivo_ruta)){
    


if(isset($_GET['id'])){
$consultaEdit = $db->consulta("SELECT * FROM registrar_actividad WHERE id=".$_GET['id']);
$edit = $db->fetch_row($consultaEdit);

$consultaGrupo = $db->consulta("SELECT anfitrion, id_lider, dia, hora_inicia, hora_finaliza FROM grupos WHERE id=".$_GET['id']);
$grupos = $db->fetch_row($consultaGrupo);
}

filtroColumnas(6);
?>
<script type="text/javascript" charset="utf8" src="../libs/scripts.js"></script>

<!-- Modal Grupos-->
<div class="modal fade" id="gruposModal" tabindex="-1" role="dialog" aria-labelledby="gruposModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="gruposlLabel">Grupos</h4>
      </div>
      <div class="modal-body">
		<table class="display datos">
		<thead>
			<tr>
                            <th>#</th>
                            <th>Anfitrión</th>
                            <th>Día</th>
                            <th>Teléfono</th>
                            <th>Líder</th>
                            <th>Horario</th>
                            <th>Seleccionar</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$sql="SELECT * FROM grupos";
		
		$consulta = $db->consulta($sql);
		$acciones = $db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
											
		if($db->num_rows($consulta)>0){
		  while($results = $db->fetch_array($consulta)){ 
			echo "<tr>";
			echo "<td>".$results['id']."</td>"; 
			echo "<td>".utf8_encode($results['anfitrion'])."</td>";
			echo "<td>".utf8_encode($results['dia'])."</td>"; 
			echo "<td>".$results['telefono']."</td>"; 
			echo "<td>".utf8_encode($db->getNombreLideres($results['id_lider']))."</td>";
			echo "<td>".$results['hora_inicia']." - ".$results['hora_finaliza']."</td>";
			echo "<td>";
			echo "<a class='btn btn-xs btn-success seleccionar_grupo'><span class='glyphicon glyphicon-ok'></span>";
			echo "<input type='hidden' value='".$results['id']."|".utf8_encode($results['anfitrion'])."|".utf8_encode($db->getNombreLideres($results['id_lider']))."|".utf8_encode($results['dia'])."|".$results['hora_inicia']." - ".$results['hora_finaliza']."'/>";
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
				<td class="text-left"><h3 class="text-muted">Registrar Actividad</h3></td>
				<td class="text-right"><a id="volver" href="../"><span class="glyphicon glyphicon-log-out"></span> Volver</a></td>
			</tr>
		</table>
	</div>
</div>
<div id="catalogo_form" class="row">
<form method=post action="ctrl/ctrl_registrar-actividad.php">
<table border=0 style="margin:0 auto; width:100%;">
<tr>
    <td style="width:130px;" class="text-right">#: &nbsp;</td>
	<td>
        <input class="form-control input-sm" type=text name="id" value="<?php if(isset($edit[0])){echo $edit[0];}?>" style="text-align:right;" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Grupo: &nbsp;</td>
	<td>
            <div class="input-group">
                <input type="text" class="form-control input-sm" type="text" id="id_grupo" name="id_grupo" value="<?php if(isset($edit[1])){echo $edit[1];}?>" required="" readonly placeholder="NO SELECCIONADO"/>
                <span class="input-group-btn">
                  <button class="btn btn-default btn-sm select-modal" type="button" data-toggle="modal" data-target="#gruposModal"><span>&#9660;</span></button>
                </span>
            </div>
	</td>
</tr>
<tr class="info-grupo">
	<td class="text-right">Anfitrión: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" id="anfitrion" value="<?php if(isset($grupos[0])){echo $grupos[0];}?>" readonly>
	</td>
</tr>
<tr class="info-grupo">
	<td class="text-right">Líder: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" id="lider" value="<?php if(isset($grupos[1])){echo utf8_encode($db->getNombreLideres($grupos[1]));}?>" readonly>
	</td>
</tr>
<tr class="info-grupo">
	<td class="text-right">Día: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" id="dia" value="<?php if(isset($grupos[2])){echo utf8_encode($grupos[2]);}?>" readonly>
	</td>
</tr>
<tr class="info-grupo">
	<td class="text-right">Horario: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" id="horario" value="<?php if(isset($grupos[3])&& isset($grupos[4])){echo $grupos[3]." - ".$grupos[4];}?>" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Fecha: &nbsp;</td>
	<td>
	<input class="form-control input-sm datepicker" type="text" name="fecha" value="<?php if(isset($edit[2])){echo $edit[2];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Asistentes: &nbsp;</td>
	<td>
	<input class="form-control input-sm numeric" placeholder="# (solo dígitos)" type="text" name="asistentes" value="<?php if(isset($edit[3])){echo $edit[3];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Invitados: &nbsp;</td>
	<td>
	<input class="form-control input-sm numeric" placeholder="# (solo dígitos)" type="text" name="invitados" value="<?php if(isset($edit[4])){echo $edit[4];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Salvos: &nbsp;</td>
	<td>
	<input class="form-control input-sm numeric" placeholder="# (solo dígitos)" type="text" name="salvos" value="<?php if(isset($edit[5])){echo $edit[5];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Monto de Ofrenda: &nbsp;</td>
	<td>
		<div class="input-group input-group-sm">
			<span class="input-group-addon">Q</span>
			<input class="form-control input-sm numeric" placeholder="0.00 (solo digitos)" type="text" name="ofrenda" value="<?php if(isset($edit[6])){echo $edit[6];}?>" required="">
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

<b>Seleccione las columnas que desea visualizar:</b>
<table class="table" id="catalogo_form">
    <tr>
        <td class="mostrarPermisos">#: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i0" checked="true"></td>
        <td class="mostrarPermisos">Grupo: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i1" checked="true"></td>
        <td class="mostrarPermisos">Fecha: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i2" checked="true"></td>
        <td class="mostrarPermisos">Asistentes: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i3" checked="true"></td>	
    </tr>
    <tr>
        <td class="mostrarPermisos">Invitados: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i4" checked="true"></td>
        <td class="mostrarPermisos">Salvos: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i5" checked="true"></td>
        <td class="mostrarPermisos">Ofrenda: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i6" checked="true"></td>
    </tr>

</table>
<table class="display datos">
<thead>
    <tr>
        <th class="head-0">#</th>
        <th class="head-1">Grupo</th>
        <th class="head-2">Fecha</th>
	<th class="head-3">Asistentes</th>
        <th class="head-4">Invitados</th>
        <th class="head-5">Salvos</th>
        <th class="head-6">Ofrenda</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
<?php 
$sql="SELECT * FROM registrar_actividad";
$consulta = $db->consulta($sql);
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
									
if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   echo "<tr>";
   echo "<td class='column-0'>".$results['id']."</td>"; 
   echo "<td class='column-1'>".$results['id_grupo']."</td>";
   echo "<td class='column-2'>".$results['fecha']."</td>"; 
   echo "<td class='column-3'>".$results['asistentes']."</td>";
   echo "<td class='column-4'>".$results['invitados']."</td>";
   echo "<td class='column-5'>".$results['salvos']."</td>";
   echo "<td class='column-6'>Q".$results['ofrenda']."</td>";
   echo "<td>";
      for($i=0;$i<count($acciones);$i++){
   	   if($acciones[$i]['titulo']!=""){
		echo "<a class='btn btn-xs btn-primary' href='".$archivo."?id=".$results['id']."'><span class='glyphicon glyphicon-".$acciones[$i]['imagen_icono']."'></span> ".utf8_encode($acciones[$i]['titulo'])."</a>";
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