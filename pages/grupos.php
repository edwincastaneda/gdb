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
$consultaEdit = $db->consulta("SELECT * FROM grupos WHERE id=".$_GET['id']);
$edit = $db->fetch_row($consultaEdit);
}



filtroColumnas(10);
?>
<script type="text/javascript" charset="utf8" src="../libs/scripts.js"></script>
<script>
function validateForm() {
	var error=0;
	var text="";
    var lider = document.forms["grupos_form"]["id_lider"].value;
	var facilitador = document.forms["grupos_form"]["id_facilitador"].value;
    if (facilitador == 0) {
		error++;
		text+="- FACILITADOR";
    }
	if (lider == 0) {
		error++;
		text+="\n- LIDER ";
    }
	
	if (error>0){
	    alert("ERROR!! Falta Información, agregue: \n\n"+text);
		return false;
	}
}
</script>
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

		$sql="SELECT * FROM servidores WHERE tipo in (1,3)";

		$consulta = $db->consulta($sql);
		$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
											
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

<!-- Modal Líderes-->
<div class="modal fade" id="lideresModal" tabindex="-1" role="dialog" aria-labelledby="lideresModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="lideresModalLabel">Líderes</h4>
      </div>
      <div class="modal-body" id="body-modal-lideres"></div>
	  <div class="modal-footer">
	  <button class="btn btn-success btn-xs" type="button" id="seleccionar_lider"><span class='glyphicon glyphicon-ok'></span> Asignar</button>
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
<form name="grupos_form" method=post action="ctrl/ctrl_grupos.php" onsubmit="return validateForm();">
<table border=0 style="margin:0 auto; width:100%;">
<tr>
    <td style="width:85px;" class="text-right">#: &nbsp;</td>
	<td>
        <input class="form-control input-sm" type=text name="id" value="<?php if(isset($edit[0])){echo $edit[0];}?>" style="text-align:right;" readonly>
	</td>
</tr>
<tr>
	<td class="text-right">Facilitador: &nbsp;</td>
	<td>
		<div class="input-group">
			<input type="text" class="form-control input-sm" type="text" id="nombre_facilitador" value="<?php if(isset($edit[1])){echo utf8_encode($db->getNombreFacilitadores($edit[1]));}?>" required="" readonly placeholder="NO SELECCIONADO"/>
			<input type="hidden" id="id_facilitador" name="id_facilitador" value="<?php if(isset($edit[1])){echo $edit[1];}else{ echo "0";}?>"/>
			<span class="input-group-btn">
			  <button class="btn btn-default btn-sm select-modal" type="button" data-toggle="modal" data-target="#facilitadoresModal"><span>&#9660;</span></button>
			</span>
		</div>
	</td>
</tr>
<tr>
	<td class="text-right">Líder: &nbsp;</td>
	<td>
		<div class="input-group">
            <input type="text" class="form-control input-sm" id="nombre_lider" value="<?php if(isset($edit[2])){

			$lideres_asignados=explode(",",$edit[2]);
			   foreach ($lideres_asignados as $value) {
			    if($db->getNombreLideres($value)!=""){
				echo trim(utf8_encode($pref.$db->getNombreLideres($value)));
				}else{
				echo trim(utf8_encode($pref.$db->getNombreFacilitadores($value)));
				}
				$pref=", ";
				}
			}
			?>" required="" readonly placeholder="NO SELECCIONADO"/>
			<input type="hidden" id="id_lider" name="id_lider" value="<?php if(isset($edit[2])){echo $edit[2];}else{ echo "0";}?>"/>
			<span class="input-group-btn">
			  <button class="btn btn-default btn-sm select-modal" id="boton-select-lider" type="button" data-toggle="modal" data-target="#lideresModal" disabled><span>&#9660;</span></button>
			</span>
		</div>
	</td>
</tr>
<tr>
	<td class="text-right">Tipo: &nbsp;</td>
	<td>
		<select style="width:100%;" class="form-control input-sm" name="tipo">
		<?php $consulta = $db->consulta("SELECT id, nombre FROM tipos_grupos");
			if($db->num_rows($consulta)>0){
				while($results = $db->fetch_array($consulta)){ 
				if(isset($edit[11])&& $edit[11]==$results[0]){?>
				<option value="<?php echo $results[0];?>" selected><?php echo utf8_encode($results[1]);?></option>
				<?php }else{ ?>
				<option value="<?php echo $results[0];?>"><?php echo utf8_encode($results[1]);?></option>
			<?php }
				}
			}?>
		</select>
	</td>
</tr>
<tr>
	<td class="text-right">Anfitrión: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="anfitrion" value="<?php if(isset($edit[3])){echo $edit[3];}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Dirección: &nbsp;</td>
	<td>
	<input class="form-control input-sm" type="text" name="direccion" value="<?php if(isset($edit[4])){echo utf8_encode($edit[4]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Teléfono: &nbsp;</td>
	<td>
	<input class="form-control input-sm numeric" type="text" name="telefono" value="<?php if(isset($edit[5])){echo $edit[5];}?>" required="" placeholder="######## (8 dígitos)" maxlength="8">
	</td>
</tr>
<tr>
	<td class="text-right">Día: &nbsp;</td>
	<td>
	<select class="form-control input-sm" name="dia">
	<option value="--" <?php if(isset($edit[6])&& $edit[6]=="--"){echo "selected";}?>>--</option>
	<option value="Lunes" <?php if(isset($edit[6])&& $edit[6]=="Lunes"){echo "selected";}?>>Lunes</option>
	<option value="Martes" <?php if(isset($edit[6])&& $edit[6]=="Martes"){echo "selected";}?>>Martes</option>
	<option value="Miércoles" <?php if(isset($edit[6])&& utf8_encode($edit[6])=="Miércoles"){echo "selected";}?>>Miércoles</option>
	<option value="Jueves" <?php if(isset($edit[6])&& $edit[6]=="Jueves"){echo "selected";}?>>Jueves</option>
	<option value="Viernes" <?php if(isset($edit[6])&& $edit[6]=="Viernes"){echo "selected";}?>>Viernes</option>
	<option value="Sábado" <?php if(isset($edit[6])&& utf8_encode($edit[6])=="Sábado"){echo "selected";}?>>Sábado</option>
	<option value="Domingo" <?php if(isset($edit[6])&& $edit[6]=="Domingo"){echo "selected";}?>>Domingo</option>
	</select>
	</td>
</tr>
<tr>
	<td class="text-right">Horario: &nbsp;</td>
	<td>
	<div class="col-md-6" style="padding:0;"><input placeholder="Inicia" class="form-control input-sm tiempo" data-format="hh:mm A" type="text" name="hora_inicia" value="<?php if(isset($edit[7])){echo utf8_encode($edit[7]);}?>" required=""></div>
	<div class="col-md-6" style="padding:0;"><input placeholder="Finaliza" class="form-control input-sm tiempo" data-format="hh:mm A" type="text" name="hora_finaliza" value="<?php if(isset($edit[8])){echo utf8_encode($edit[8]);}?>" required=""></div>
	
	</td>
</tr>
<tr>
	<td class="text-right">Directrices: &nbsp;</td>
	<td>
	<textarea class="form-control"  name="directrices" required="" rows="5"><?php if(isset($edit[9])){echo utf8_encode($edit[9]);}?></textarea>
	</td>
</tr>
<tr>
	<td class="text-right">Transporte: &nbsp;</td>
	<td>
	<textarea class="form-control" name="transporte" required="" rows="5"><?php if(isset($edit[10])){echo utf8_encode($edit[10]);}?></textarea>
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
        <td class="mostrarPermisos">Facilitador: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i1"></td>
        <td class="mostrarPermisos">Líder: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i2" checked="true"></td>
		<td class="mostrarPermisos">Tipo: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i3" checked="true"></td>
	</tr>
	<tr>
		<td class="mostrarPermisos">Anfitrión: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i4"></td>
		<td class="mostrarPermisos">Dirección: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i5" checked="true"></td>
        <td class="mostrarPermisos">Teléfono: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i6" checked="true"></td>
        <td class="mostrarPermisos">Día: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i7" checked="true"></td>
	</tr>
	<tr>
		<td class="mostrarPermisos">Horario: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i8" checked="true"></td>
		<td class="mostrarPermisos">Directrices: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i9"></td>
		<td class="mostrarPermisos">Transporte: &nbsp;</td>
        <td class="mostrarPermisosCheck"><input type="checkbox" id="i10"></td>
		
    </tr>

</table>
</li>
</ul>
<table class="display datos">
<thead>
    <tr>
        <th class="head-0">#</th>
        <th class="head-1">Facilitador</th>
        <th class="head-2">Líder</th>
		<th class="head-3">Tipo</th>
		<th class="head-4">Anfitrión</th>
        <th class="head-5">Dirección</th>
        <th class="head-6">Teléfono</th>
        <th class="head-7">Día</th>
        <th class="head-8">Horario</th>
		<th class="head-9">Directrices</th>
		<th class="head-10">Transporte</th>
        <th class="head-11">Acciones</th>
    </tr>
</thead>
<tbody>
<?php 
$sql="SELECT * FROM grupos";
$consulta = $db->consulta($sql);
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);									
									
if($db->num_rows($consulta)>0){
	
	
  while($results = $db->fetch_array($consulta)){ 
   $lider_arr="";
   $pref="";
   
   $lideres_asignados=explode(",",$results['id_lider']);
   
   foreach ($lideres_asignados as $value) {
   if($db->getNombreLideres($value)!=""){
	$lider_arr.=$pref.$db->getNombreLideres($value);
	}else{
	$lider_arr.=$pref.$db->getNombreFacilitadores($value);
	}
	$pref="<br/>";
	}
	
  
   echo "<tr>";
   echo "<td class='column-0'>".$results['id']."</td>"; 
   echo "<td class='column-1'>".utf8_encode($db->getNombreFacilitadores($results['id_facilitador']))."</td>";
   //echo "<td class='column-2'>".utf8_encode($db->getNombreLideres($results['id_lider']))."</td>";
   echo "<td class='column-2'>".utf8_encode($lider_arr)."</td>";
   echo "<td class='column-3'>".utf8_encode($db->getTipoGrupo($results['tipo']))."</td>";
   echo "<td class='column-4'>".utf8_encode($results['anfitrion'])."</td>"; 
   echo "<td class='column-5'>".utf8_encode($results['direccion'])."</td>";
   echo "<td class='column-6'>".$results['telefono']."</td>";
   echo "<td class='column-7'>".utf8_encode($results['dia'])."</td>";
   echo "<td class='column-8'>".$results['hora_inicia']." - ".$results['hora_finaliza']."</td>";
   echo "<td class='column-9'>".$results['directrices']."</td>";
   echo "<td class='column-10'>".$results['transporte']."</td>";
   echo "<td class='column-11'>";
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