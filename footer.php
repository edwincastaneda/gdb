	<footer class="footer text-right">
		<div>
		<?php if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){
		echo "Conectado como: <span style='color:#06A5AA;'><b><span class='glyphicon glyphicon-user'></span> ".$_COOKIE['username']."</b></span>";
		}else{
		echo "Sesión no iniciada";
		}
		?>
		</div>
		<div class="text-center" style="font-size: 10px;">&copy; Iglesia El Shaddai Guatemala, <?php echo date('Y'); ?></div>
    </footer>

</div> <!-- /container -->
</body>

</html>