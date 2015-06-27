<?php
include_once "header.php";
include "clases/mysql.php";
$db = new MySQL();
	if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){
	
	$paginas=$db->getPaginas($_COOKIE['id_perfil']);?>
	
	
	<?php 
	if($paginas[0]['ruta_php']!=""){?>
	<div class="list-group" style="margin-top:20px;">
	<?php for($i=0;$i<count($paginas);$i++){?>
		<a href="<?php host_url($f); echo $paginas[$i]['ruta_php'];?>" class="list-group-item">
		<div style="float:left; background:#B5CE3F; background-image:url(images/icons/<?php echo $paginas[$i]['imagen_icono'];?>); width:50px; height:50px; margin-right:10px;"/></div>
					<h4 class="list-group-item-heading"><?php echo utf8_encode($paginas[$i]['titulo']);?></h4>
				    <p style="padding-bottom:8px;" class="list-group-item-text"><?php echo utf8_encode($paginas[$i]['descripcion']);?></p>
		</a>
	<?php }
	echo "</div>";
	}else{
	echo "<div style='margin-top:20px;' class='well well-lg'>No hay elementos disponibles para este perfil de usuario, contacte al administrador del sistema.</div>";
	}	?>
	
	
	<?php
$db->desconectar();
// FIN SESION
}else{?>
            <div style="margin-top:20px;" class="well well-lg">Debe de iniciar sesión para poder ver este contenido! <a href='<?php host_url($f);?>login.php'>Iniciar Sesión</a></div>
	
<?php }?>

<?php include_once "footer.php" ?>