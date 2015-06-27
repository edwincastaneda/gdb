<?php 
include("../../clases/mysql.php");
$db = new MySQL();
?>
<table class="display datosModal">
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
		
		$sql="SELECT * FROM servidores WHERE tipo in(2,3) AND id_facilitador in(".$_POST['id_facilitador'].") OR id_facilitador in (SELECT id FROM servidores WHERE tipo=3)";
		$consulta = $db->consulta($sql);								
		$lideres_asignados=explode(",",$_POST['selected']);		
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
			//echo "<a class='btn btn-xs btn-success seleccionar_lider'><span class='glyphicon glyphicon-ok'></span>";
			//echo "<input type='hidden' value='".$results['id']."|".utf8_encode($results['nombres'])." ".utf8_encode($results['apellidos'])."'/>";
			
			if (in_array((string)$results['id'], $lideres_asignados)) {
				echo "<div class='checkbox' id='chkbox_lideres'><input type='checkbox' name='".$results['id']."|".utf8_encode($results['nombres'])." ".utf8_encode($results['apellidos'])."' checked></div>";
			}else{
				echo "<div class='checkbox' id='chkbox_lideres'><input type='checkbox' name='".$results['id']."|".utf8_encode($results['nombres'])." ".utf8_encode($results['apellidos'])."'></div>";
			}
			
			echo "</a>";
			echo "</td>";
			echo "</tr>";
			}
		 }
		 ?>
</tbody>
</table>