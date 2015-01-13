<!DOCTYPE html>
<html lang="en">
<head>
<?php include "libs/funciones.php";?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Grupos de Bendición</title>

<?php $f="gdb";?>

<link rel="shortcut icon" href="<?php host_url($f);?>favicon.png" />

<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/bootstrap-theme.min.css">

<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/comun.css">
<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/clockface.css">
<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/datepicker.css">

<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php host_url($f);?>css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/clockface.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/dataTables.bootstrap.js"></script>
 
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/collapse.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/modal.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/transition.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/tooltip.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/popover.js"></script>
<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/jquery.numeric.js"></script>


<script type="text/javascript" charset="utf8" src="<?php host_url($f);?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(window).load(function(){
  $('#loading').fadeOut('fast');
});


$(document).ready( function () {
	//datatable
    $('.datos').DataTable( {
        language: {
            url: '<?php host_url($f);?>libs/es_ES.txt'
        }
    } );
	
	//accordion
	$('.collapse').collapse();
	
	//clockface
    $('.tiempo').clockface();  
	
	//datepicker
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	}).on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
	
	$("input.numeric").numeric();
	
});


</script>


</head>
<body>
<div id="loading"></div>

<div class="container">
  <div class="header">
	<nav>
        <img src="<?php host_url($f);?>logo.png"/>
	  <ul class="nav nav-pills pull-right">
		<li role="presentation" class="active">
		<?php if(isset($_COOKIE["username"]) || isset($_COOKIE["password"])){  ?>
			<a  style="background:#06A5AA;" href="<?php host_url($f);?>logout.php"><span class="glyphicon glyphicon-off"></span> Salir</a>
		<?php } ?>
		</li>
	  </ul>
	  <!--<h3 class="text-muted">Project name</h3>-->
	</nav>
  </div>
