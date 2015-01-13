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
			echo "<tr>";
			echo "<td>".$results['id']."</td>"; 
			echo "<td>".utf8_encode($db->getNombreFacilitadores($results['id_facilitador']))."</td>";
			echo "<td>".utf8_encode($db->getNombreLideres($results['id_lider']))."</td>"; 
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