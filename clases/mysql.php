<?php
class MySQL{

  private $conexion; private $total_consultas;

  public function MySQL(){ 
    if(!isset($this->conexion)){
	if($_SERVER['SERVER_NAME']=="gdb.elshaddai.net"){
      $this->conexion = (mysql_connect("localhost","shaddai_gdb","3lShaddai2015"))
        or die(mysql_error());
		}else{
		$this->conexion = (mysql_connect("localhost","root","root"))
        or die(mysql_error());
		}
      mysql_select_db("shaddai_gdb",$this->conexion) or die(mysql_error());
    }
  }

  public function consulta($consulta){ 
    $this->total_consultas++; 
    $resultado = mysql_query($consulta,$this->conexion);
    if(!$resultado){ 
      echo 'MySQL Error: ' . mysql_error();
      exit;
    }
    return $resultado;
  }

  public function fetch_array($consulta){
   return mysql_fetch_array($consulta);
  }
  
  public function fetch_row($consulta){
   return mysql_fetch_row($consulta);
  }

  public function num_rows($consulta){
   return mysql_num_rows($consulta);
  }

  public function getTotalConsultas(){
   return $this->total_consultas; 
  }
  
  public function desconectar(){
   return mysql_close();
  }
  
  public function validaPagina($id_perfil, $pagina){
  $retorna=false;
  		$consulta = $this->consulta("SELECT ruta_php 
									FROM opciones
									WHERE id IN (SELECT id_permisos FROM asigna_permisos WHERE id_perfiles=".$id_perfil.")
									AND tipo=1");
		if($this->num_rows($consulta)>0){
			while($results = $this->fetch_array($consulta)){
				//$retorna[]=$results[0];
				if($results[0]== $pagina){
					$retorna=true;
				}
			}	
		}
  
   return $retorna;
  }
  
  public function getPaginas($id_perfil){
  $retorna=false;
  $sql="SELECT * 
		FROM opciones
		WHERE id IN (SELECT id_permisos FROM asigna_permisos WHERE id_perfiles=".$id_perfil.")
		AND tipo=1";
  		$consulta = $this->consulta($sql);
		if($this->num_rows($consulta)>0){
			while($results = $this->fetch_array($consulta)){
				$retorna[] = array("nombre" => $results["nombre"], "titulo" => $results["titulo"], "ruta_php" => $results["ruta_php"], "descripcion" => $results["descripcion"], "imagen_icono" => $results["imagen_icono"]);
			}	
		}
  
   return $retorna;
  }
  
public function getAcciones($id_perfil, $ruta_php,$tipo){
$retorna=false;
$sql="SELECT * 
      FROM opciones
      WHERE id IN (SELECT id_permisos FROM asigna_permisos WHERE id_perfiles=".$id_perfil.")
      AND tipo=".$tipo." AND ruta_php='".$ruta_php."'";
      
  		$consulta = $this->consulta($sql);
		if($this->num_rows($consulta)>0){
			while($results = $this->fetch_array($consulta)){
				$retorna[] = array("nombre" => $results["nombre"], "titulo" => $results["titulo"], "ruta_php" => $results["ruta_php"], "descripcion" => $results["descripcion"], "imagen_icono" => $results["imagen_icono"]);
			}	
		}
   return $retorna;
  }
  
  public function getCheckPermisos($id_perfil,$id_permiso){
   $retorna="";
  		$consulta = $this->consulta("SELECT TRUE FROM asigna_permisos WHERE id_perfiles=".$id_perfil." AND id_permisos=".$id_permiso);
		if($this->num_rows($consulta)>0){
			$retorna="checked";
		}
  
   return $retorna;
  }
  
    public function getNombrePagina($nombre){
   $retorna="";
  		$consulta = $this->consulta("SELECT titulo FROM opciones WHERE nombre='".$nombre."'");
		$result = $this->fetch_row($consulta);
		$retorna=$result[0];
  
   return $retorna;
  }
  
public function getNombreFacilitadores($id_facilitador){
  $sql="SELECT id, nombres, apellidos  
		FROM servidores
		WHERE tipo in (1,3) AND id=".$id_facilitador;
  		$consulta = $this->consulta($sql);
		$result = $this->fetch_row($consulta);
		if($this->num_rows($consulta)>0){
			$retorna=$result[0]." - ".$result[1]." ".$result[2];
		}
  
   return $retorna;
}

public function getNombreLideres($id_lider){
  $sql="SELECT id, nombres, apellidos  
		FROM servidores
		WHERE tipo =2 AND id=".$id_lider;
  		$consulta = $this->consulta($sql);
		$result = $this->fetch_row($consulta);
		if($this->num_rows($consulta)>0){
			$retorna=$result[0]." - ".$result[1]." ".$result[2];
		}
  
   return $retorna;
}

public function getTipoGrupo($id_tipo_grupo){
  $sql="SELECT id, nombre 
		FROM tipos_grupos
		WHERE id=".$id_tipo_grupo;
  		$consulta = $this->consulta($sql);
		$result = $this->fetch_row($consulta);
		if($this->num_rows($consulta)>0){
			$retorna=$result[1];
		}
  
   return $retorna;
}


}?>