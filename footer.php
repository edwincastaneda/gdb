	<footer class="footer text-right">
        <!--<p>&copy; Iglesia El Shaddai Guatemala, 2014</p>-->
		<?php if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['id_perfil'])){
		echo "Conectado como: <span style='color:#06A5AA;'><b><span class='glyphicon glyphicon-user'></span> ".$_COOKIE['username']."</b></span>";
		}else{
		echo "Sesión no iniciada";
		}
		?>
    </footer>

</div> <!-- /container -->
</body>

</html>