<?php 
include ("../header.php");
include("../clases/mysql.php");
$db = new MySQL();
$archivo="perfiles.php";
$archivo_ruta="pages/".$archivo;

//SESION INICIADA
if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){ 

//PERMISOS PARA VER LA PAGINA
if($db->validaPagina($_COOKIE['id_perfil'],$archivo_ruta)){

if(isset($_GET['id'])){
$consultaEdit = $db->consulta("SELECT * FROM perfiles WHERE id=".$_GET['id']);
$edit = $db->fetch_row($consultaEdit);
}
?>

<script>
$(document).on( "click", "#marcar-todos", function() {
    $('#accordion').find(':checkbox').each(function(){
        $(this).prop('checked', true);
    });    
});
$(document).on( "click", "#desmarcar", function() {
    $('#accordion').find(':checkbox').each(function(){
        $(this).prop('checked', false);
    });    
});
</script>
<div class="row">

	<div class="col-md-12">
		<table style="width:100%;">
			<tr>
				<td class="text-left"><h3 class="text-muted">Perfiles</h3></td>
				<td class="text-right"><a id="volver" href="../"><span class="glyphicon glyphicon-log-out"></span> Volver</a></td>
			</tr>
		</table>
	</div>
</div>
<div id="catalogo_form" class="row">
<form method=post action="ctrl/ctrl_perfiles.php">
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
	<input class="form-control input-sm" type="text" name="nombre" value="<?php if(isset($edit[1])){echo utf8_encode($edit[1]);}?>" required="">
	</td>
</tr>
<tr>
	<td class="text-right">Descripción: &nbsp;</td>
	<td>
	<textarea class="form-control input-sm" name="descripcion"  required="" ><?php if(isset($edit[2])){echo utf8_decode($edit[2]);}?></textarea>
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
</div>
<div class="row">


<?php if(isset($_GET['id'])){ ?>
    <h4>Seleccione los permisos para el perfil: <small><a style="cursor:pointer;" id="marcar-todos">Todos</a> | <a style="cursor:pointer;" id="desmarcar">Ninguno</a></small></h3>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingPaginas">
      <h4 class="panel-title" style="font-size:14px;">
        <a data-toggle="collapse" data-parent="#accordion" href="#paginas" aria-expanded="true" aria-controls="paginas" style="text-decoration:none;">
            <p style="margin:0;">Páginas</p>
        </a>
      </h4>
    </div>
    <div id="paginas" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPaginas">
      <div class="panel-body">
        <table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Título</th>
				<th>Ruta</th>
				<th>Marcar</th>
			</tr>
		</thead>
		<?php 
		$consulta = $db->consulta("SELECT * FROM opciones WHERE tipo=1");
		if($db->num_rows($consulta)>0){
			  while($results = $db->fetch_array($consulta)){
			   echo "<tr>";
			   echo "<td>".$results['id']."</td>"; 
			   echo "<td>".$results['nombre']."</td>"; 
			   echo "<td>".$results['titulo']."</td>"; 
			   echo "<td>".$results['ruta_php']."</td>";
			   echo '<td><input type="checkbox" name="'.$results['id'].'" '.$db->getCheckPermisos($_GET['id'],$results['id']).'>'; 
			 }
		 }
		 ?>
		</table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingAcciones">
      <h4 class="panel-title" style="font-size:14px;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Acciones" aria-expanded="false" aria-controls="Acciones" style="text-decoration:none;">
            <p style="margin:0;">Acciones</p>
        </a>
      </h4>
    </div>
    <div id="Acciones" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingAcciones">
      <div class="panel-body">
        <table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Título</th>
				<th>Ruta</th>
				<th>Marcar</th>
			</tr>
		</thead>
		<?php 
		$consulta = $db->consulta("SELECT * FROM opciones WHERE tipo=2");
		if($db->num_rows($consulta)>0){
			  while($results = $db->fetch_array($consulta)){
			   echo "<tr>";
			   echo "<td>".$results['id']."</td>"; 
			   echo "<td>".$results['nombre']."</td>"; 
			   echo "<td>".$results['titulo']."</td>"; 
			   echo "<td>".$results['ruta_php']."</td>";
			   echo '<td><input type="checkbox" name="'.$results['id'].'" '.$db->getCheckPermisos($_GET['id'],$results['id']).'></td></tr>'; 
			 }
		 }
		 ?>
		</table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingBotones">
      <h4 class="panel-title" style="font-size:14px;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#botones" aria-expanded="false" aria-controls="botones" style="text-decoration:none;">
            <p style="margin:0;">Botones</p>
        </a>
      </h4>
    </div>
    <div id="botones" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBotones">
      <div class="panel-body">
        <table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Título</th>
				<th>Ruta</th>
				<th>Marcar</th>
			</tr>
		</thead>
		<?php 
		$consulta = $db->consulta("SELECT * FROM opciones WHERE tipo=3");
		if($db->num_rows($consulta)>0){
			  while($results = $db->fetch_array($consulta)){
			   echo "<tr>";
			   echo "<td>".$results['id']."</td>"; 
			   echo "<td>".$results['nombre']."</td>"; 
			   echo "<td>".$results['titulo']."</td>"; 
			   echo "<td>".$results['ruta_php']."</td>";
			   echo '<td><input type="checkbox" name="'.$results['id'].'" '.$db->getCheckPermisos($_GET['id'],$results['id']).'></td></tr>'; 
			 }
		 }
		 ?>
		</table>
      </div>
    </div>
  </div>
</div>
<?php } ?>
</form>

<table class="display datos">
<thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
<?php 
$consulta = $db->consulta("SELECT * FROM perfiles");
$acciones=$db->getAcciones($_COOKIE['id_perfil'],$archivo_ruta,2);

if($db->num_rows($consulta)>0){
  while($results = $db->fetch_array($consulta)){ 
   echo "<tr><td>".$results['id']."</td>"; 
   echo "<td class='text-left'>".utf8_encode($results['nombre'])."</td>"; 
   echo "<td class='text-left'>".utf8_encode($results['descripcion'])."</td>";
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