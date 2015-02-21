<?php 
class Participaciones extends ActiveRecord{
	public function subirMP3s($id_sesion){
		if (!isset($_FILES['sesion_archivos'])) {
			return null;
		}
		$fecha = date("Y-m-d_H:i:s");
		for($i=0; $i<count($_FILES['sesion_archivos']['name']); $i++) {
		  //Get the temp file path
		  $tmpFilePath = $_FILES['sesion_archivos']['tmp_name'][$i];

		  //Make sure we have a filepath
		  if ($tmpFilePath != ""){
		    //Setup our new file path
		    if (!file_exists(getcwd()."/files/uploads/".$id_sesion."/")) {
		    	mkdir(getcwd()."/files/uploads/".$id_sesion,0777,true);
		    	$newFilePath = getcwd()."/files/uploads/".$id_sesion."/".$fecha."_".$_FILES['sesion_archivos']['name'][$i];
		    }else{

		    	$newFilePath = getcwd()."/files/uploads/".$id_sesion."/".$fecha."_".$_FILES['sesion_archivos']['name'][$i];
		    }

		    //Upload the file into the temp dir
		    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
		    	$parcitipacion = new Participaciones();
		    	$parcitipacion->sesiones_id = $id_sesion;
		    	$trozo = explode("_", $_FILES['sesion_archivos']['name'][$i]);
		    	$trozo = $trozo[1];
		    	$trozo = explode("mp3", $trozo);
		    	$parcitipacion->nombre_participante = str_replace(".", "", $trozo[0]);
		    	$trozo = explode("_", $_FILES['sesion_archivos']['name'][$i]);
		    	$parcitipacion->tiempo = str_replace("-", ":", $trozo[0]);
		    	$parcitipacion->ruta = $newFilePath;
		    	if (!$parcitipacion->save()) {
		    		Flash::error("Ocurrio un error subiendo el archivo: ".$_FILES['sesion_archivos']['name'][$i]);
		    	}
		    }
		  }
}
	}
	public function cambiarstatus($participacion_id){
		$sesion = $this->find($participacion_id);

		if ($sesion->status) {
			$sesion->status = false;
		}else{
			$sesion->status = true;
		}
		if ($sesion->update()) {
			return true;
		}
		return false;
	}
	public function getParticipacionesBySesionId($id,$order=null){
		if ($order) {
			return $this->find("conditions: sesiones_id = '$id'","order: $order");
		}
		return $this->find("conditions: sesiones_id = '$id'");
	}
	public function getMenorTiempoDeSesion($sesion_id){
		$tiempo =  $this->find("conditions: sesiones_id = '$sesion_id'","order: tiempo asc");
		return $tiempo[0]->tiempo;
	}
	public function verificarFechaSesion($fecha){
		$f = explode("-",$fecha);
		if (strlen($f[0]) == 4) {
			return $f[2]."-".$f[1]."-".$f[0];
		}else{
			return $fecha;
		}
	}
	public function validarParticipacionesDeSesiones($sesiones){

		foreach ($sesiones as $key => $value) {
			if ($value->sesion_abierta) {
			
				$entidad = Load::model("entidad")->find($value->entidad_id);
				if (is_dir(getcwd()."/files/uploads/".$entidad->nombre)) {
					/*esto hay que hacerlo porque la carpeta de la sesion se crea automaticamente con el formato
					de fecha dd-mm-yyyy y en la base de datos al guardarlo, cambia el formato a yyyy-mm-dd
					entonces el directorio en relacion a la base de datos queda con fechas en diferente formato*/
				
					$fecha_sesion = $this->verificarFechaSesion($value->fecha_sesion);
					if (is_dir(getcwd()."/files/uploads/".$entidad->nombre."/".$fecha_sesion.".".$value->nombre)) {
						if ($archivos = $this->getArchivosDeCarpeta(getcwd()."/files/uploads/".$entidad->nombre."/".$fecha_sesion.".".$value->nombre)) {
							/*insertar los archivos en la tabla participaciones*/
							for ($i=0; $i < count($archivos) ; $i++) { 
								$nueva = Load::model("participaciones");
								$nueva->sesiones_id = $value->id;
								$tiempo_y_nombre_con_extencion_array = explode("_",$archivos[$i]);
								$tiempo = $tiempo_y_nombre_con_extencion_array[0];
								$nombre_array = explode(".mp3",$tiempo_y_nombre_con_extencion_array[1]);
								$nombre_participante = $nombre_array[0];
								$nueva->nombre_participante = $nombre_participante;
								$nueva->tiempo = str_replace("-", ":", $tiempo);
								$nueva->status = null;
								$nueva->ruta = getcwd()."/files/uploads/".$entidad->nombre."/".$value->nombre."/".$archivos[$i];
								if (!$nueva->save()) {
									$error = 1;
									Flash::error("Hubo un error al guardar la participacion con nombre ".$archivos[$i]." en la base de datos");
								}
							}
							if (!isset($error)) {
								$sesion = Load::model("sesiones")->find($value->id);
								$sesion->sesion_abierta = 0;
								if (!$sesion->update()) {
									Flash::error("Error al cambiar el esta de la sesión");
								}
							}
						}
					}else{
						Flash::error("No hay creado un directorio para la sesión ".$value->nombre);
					}
				}else{
					Flash::error("No hay creado un directorio para la entidad ".$entidad->nombre);
				}
			}
		}
	}
	public function getArchivosDeCarpeta($path){
		$directorio = opendir($path); //ruta actual
		while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
		{
		    if (is_dir($archivo))//verificamos si es o no un directorio
		    {
		        //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
		    }
		    else
		    {
		    	if ($archivo != "documentos") {
		    		# code...
		    	$archivos[]=$archivo;
		    	}
		    }
		}
		closedir($directorio);
		if (isset($archivos)) {
			return $archivos;
		}
		return null;
	}
	public function getMenorHoraBySesionesId($id){
		$tiempo = $this->find("conditions: sesiones_id = '$id'","limit: 1","order: tiempo asc","columns: tiempo");
		if (isset($tiempo[0]->tiempo)) {
			return $tiempo[0]->tiempo;
		}
		return null;
	}
	public function getSesionesConParticipaciones(){
		return $this->find("group: sesiones_id","columns: sesiones_id");
	}
	public function getSesionEncriptada($sesion_encriptada){
		$sesiones = $this->getSesionesConParticipaciones();
		foreach ($sesiones as $key => $value) {
			if (md5($value->sesiones_id) == $sesion_encriptada) {
				return $value->sesiones_id;
			}
		}
	}
}

 ?>