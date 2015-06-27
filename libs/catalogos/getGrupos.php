<?php 
include("../../clases/mysql.php");
$db = new MySQL();
?>
<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Facilitador</th>
				<th>Líder</th>
				<th>Tipo</th>
				<th>Anfitrión</th>
				<th>Dirección</th>
				<th>Teléfono</th>
				<th>Día</th>
				<th>Horario</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
		$sql="SELECT * FROM grupos WHERE id=".$_POST['id_grupo'];
		$consulta = $db->consulta($sql);										
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
			echo "<td>".$results['id']."</td>"; 
			echo "<td>".utf8_encode($db->getNombreFacilitadores($results['id_facilitador']))."</td>";
			echo "<td>".utf8_encode($lider_arr)."</td>";			
			echo "<td>".utf8_encode($db->getTipoGrupo($results['tipo']))."</td>";
			echo "<td>".utf8_encode($results['anfitrion'])."</td>"; 
			echo "<td>".utf8_encode($results['direccion'])."</td>";
			echo "<td>".$results['telefono']."</td>";
			echo "<td>".utf8_encode($results['dia'])."</td>";
			echo "<td>".$results['hora_inicia']." - ".$results['hora_finaliza']."</td>";
			echo "</tr>";
			}
		 }
		 ?>
</tbody>
</table>