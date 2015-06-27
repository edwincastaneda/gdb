<?php 
include ("../header.php");
include("../clases/mysql.php");
$db = new MySQL();

$archivo=substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$nombre_pagina=trim(substr($archivo,0,+strrpos($archivo,".")));
$archivo_ruta="pages/".$archivo;

//SESION INICIADA
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){ 

//PERMISOS PARA VER LA PAGINA
if($db->validaPagina($_COOKIE['id_perfil'],$archivo_ruta)){

if(isset($_POST['del']) && isset($_POST['al'])){
$filtrado=true;
}

?>
<script type="text/javascript" charset="utf8" src="../libs/scripts.js"></script>



<!-- Modal Grupos Todos-->
<div class="modal fade" id="gruposTodosModal" tabindex="-1" role="dialog" aria-labelledby="gruposTodosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="gruposTodoslLabel">Grupos</h4>
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
		   $lider_arr="";
		   $pref="";
		   
		   $lideres_asignados=explode(",",$results['id_lider']);
		   
		   foreach ($lideres_asignados as $value) {
			$lider_arr.=$pref.$db->getNombreLideres($value);
			$pref=", ";
			}	
			echo "<tr>";
			echo "<td>".$results['id']."</td>"; 
			echo "<td>".utf8_encode($results['anfitrion'])."</td>";
			echo "<td>".utf8_encode($results['dia'])."</td>"; 
			echo "<td>".$results['telefono']."</td>"; 
			//echo "<td>".$results['id_lider']."</td>";
			echo "<td>".utf8_encode($lider_arr)."</td>";
			echo "<td>".$results['hora_inicia']." - ".$results['hora_finaliza']."</td>";
			echo "<td>";
			echo "<a class='btn btn-xs btn-success seleccionar_grupo'><span class='glyphicon glyphicon-ok'></span>";
			echo "<input type='hidden' value='".$results['id']."|".utf8_encode($results['anfitrion'])."|".utf8_encode($lider_arr)."|".utf8_encode($results['dia'])."|".$results['hora_inicia']." - ".$results['hora_finaliza']."'/>";
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

<!-- Modal Grupos-->
<div class="modal fade" id="gruposModal" tabindex="-1" role="dialog" aria-labelledby="gruposModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="gruposModalLabel">Grupos</h4>
      </div>
      <div class="modal-body" id="body-modal-grupos"></div>
    </div>
  </div>
</div>



<div class="row">

	<div class="col-md-12">
		<table style="width:100%;">
			<tr>
				<td class="text-left"><h3 class="text-muted"><?php echo $db->getNombrePagina($nombre_pagina);?> <small><?php if(isset($filtrado)){echo " (".$_POST['del']." / ".$_POST['al'].")";}?></small></h3></td>
				<td class="text-right"><a id="volver" href="../"><span class="glyphicon glyphicon-log-out"></span> Volver</a></td>
			</tr>
		</table>
	</div>
</div>


<div id="catalogo_form" class="row">
<form method="post" action="reportes.php">	
<table border=0 style="margin:0 auto; width:100%;">
<tr>
	<td class="text-right">Grupo: &nbsp;</td>
	<td>
            <div class="input-group">
                <input type="text" class="form-control input-sm" type="text" id="id_grupo" name="id_grupo" value="<?php if(isset($edit[1])){echo $edit[1];}?>" required="" readonly placeholder="NO SELECCIONADO (MOSTRAR TODOS)"/>
                <span class="input-group-btn">
                  <button class="btn btn-default btn-sm select-modal" type="button" data-toggle="modal" data-target="#gruposTodosModal"><span>&#9660;</span></button>
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
	<td style="width:100px;" class="text-right">Del: &nbsp;</td>
	<td>
	<input class="form-control input-sm datepicker" type="text" name="del" required="">
	</td>
</tr>
<tr>
	<td class="text-right">&nbsp;&nbsp;Al: &nbsp;</td>
	<td>
	<input class="form-control input-sm datepicker" type="text" name="al" required="">
	</td>
</tr>
<tr class="text-right">
	<td colspan=4 style="padding:10px 0 15px 0;">
	<?php  
	if(isset($filtrado)){
	echo "<a class='btn btn-xs btn-danger' href='".$archivo."'><span class='glyphicon glyphicon-ban-circle'></span> Cancelar</a>";
	}
	?>
	<button type='submit' class='btn btn-xs btn-primary' value='fecha' name='buscar'><span class='glyphicon glyphicon-search'></span> Buscar</button>
</button>


	</td>
</tr>
</table>
</form>
</div>

<?php 
if(isset($filtrado)){ 

if($_POST['id_grupo']!=""){
$sql_add_grupo=" AND id_grupo=".$_POST['id_grupo'];
}else{
$sql_add_grupo="";    
}

$headerSQL="SELECT sum(asistentes) as asistentes,
sum(invitados) as invitados,
sum(salvos) as salvos,
sum(ofrenda) as salvos
 FROM registrar_actividad WHERE fecha BETWEEN '".$_POST['del']."' AND '".$_POST['al']."'".$sql_add_grupo;
 

$header = $db->consulta($headerSQL);
$results = $db->fetch_row($header)
?>
<table class="display datos">
<thead>
    <tr>
        <th>Grupo</th>
        <th>Fecha</th>
        <th>Asistentes <span class="label label-success"><?php echo $results[0];?></span></th>
		<th>Invitados <span class="label label-success"><?php echo $results[1];?></span></th>
		<th>Salvos <span class="label label-success"><?php echo $results[2];?></span></th>
		<th>Ofrenda <span class="label label-success">Q<?php echo round($results[3], 2);?></span></th>
    </tr>
</thead>
<tbody>
<?php
$sql="SELECT * FROM registrar_actividad WHERE fecha BETWEEN '".$_POST['del']."' AND '".$_POST['al']."'".$sql_add_grupo;
$consulta = $db->consulta($sql);

if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   echo '<td><button class="btn btn-primary btn-xs" type="button" data-toggle="modal" value="'.$results["id_grupo"].'" id="mostrar-modal-grupo"><span>'.$results["id_grupo"].'</span></button></td>';
   echo "<td>".$results['fecha']."</td>";    
   echo "<td>".$results['asistentes']."</td>";    
   echo "<td>".$results['invitados']."</td>";  
   echo "<td>".$results['salvos']."</td>";   
   echo "<td>Q".$results['ofrenda']."</td>";
   echo "</tr>";
 }
}
 ?>
</tbody>
 </table>
 
<?php
}


 
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