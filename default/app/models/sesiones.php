<?php 
class Sesiones extends ActiveRecord{

	/*este arroja solo el numero de sesiones*/
	public function getSesionesDeEntidadId($id){
		$sesiones = $this->find("conditions: entidad_id = '$id'");
		return count($sesiones);
	}
	public function getSesionesByEntidadId($entidad_id,$vercarpeta=null){
		//die("condition: entidad_id='$entidad_id'");
		if ($vercarpeta) {
			
			$entidad = Load::model("entidad")->find($entidad_id);
			$this->buscarSesionesByEntidadNombre($entidad->nombre);
		}
		return $this->find("condition: entidad_id='$entidad_id'");
	}
	/*public function verificarCarpetaDeSesion($entidad){
		$path = getcwd()."/files/uploads/".$entidad;
		if (is_dir($path)) {
			if ($archivos = $this->getArchivosDeCarpeta($path)) {
				
			}
		}else{
			Flash::error("Contacte con el administrador, para verificar un error de sesión");
		}
	}*/
	public function getDirectoriosDeCarpeta($folder){

		if ($dir = opendir($folder)){ 

		    while(false !== ($file = readdir($dir))) {
		        if ($file == '.' || $file == '..') {
		            continue;
		        } else if (is_dir($folder . '/' . $file)) {
		            $files[] = $file;
		        }
		    }   

		    closedir($dir);    
		    return isset($files) ? $files : null;
		}
	}
	/*esto busca la sesiones, si no son repetidas, la guarda*/
	public function buscarSesionesByEntidadNombre($entidad_nombre){
		$path = getcwd()."/files/uploads/$entidad_nombre";
		//echo $path."<br>";
		if (is_dir($path)) {
			if ($directorios = $this->getDirectoriosDeCarpeta($path)) {
				//die(Util::pre($directorios));
				for ($i=0; $i <count($directorios) ; $i++) { 
					//var_dump($directorios[$i]);
					$trozos = explode(".",$directorios[$i]);
					$fecha_sesion = $trozos[0];
					$nombre_sesion = $trozos[1];
					/*si no existe la sesion*/
					if (!$this->getSesionByNombre($nombre_sesion,$entidad_nombre,$fecha_sesion)) {

						$entidad = Load::model("entidad")->getEntidadByNombre($entidad_nombre);
						$sesion = new Sesiones();
						$sesion->entidad_id = $entidad->id;
						$sesion->fecha_sesion = $fecha_sesion;
						$sesion->nombre = $nombre_sesion;
						if (!$sesion->save()) {
							Flash::error("Hubo un error al crear una sesion con el nombre $sesion->nombre");
						}else{
							$pathImagen_sesion = getcwd()."/img/uploads/sesiones/$entidad_nombre/$sesion->nombre";
							if (!is_dir(getcwd()."/img/uploads/sesiones/$entidad_nombre/")) {
								mkdir(getcwd()."/img/uploads/sesiones/$entidad_nombre/",0777,true);
							}
							if (!is_dir($pathImagen_sesion)) {
								mkdir($pathImagen_sesion,0777,true);
							}
						}
					}
				}
			}
		}else{
			Flash::error("Error no se encontro el directorio de la entidad con el nombre $entidad_nombre");
		}
		
	}

	public function subirImagen(){
		$fecha = date("Y-m-d_H:i:s");
		/*if (!file_exists(getcwd()."/img/uploads/sesiones/".$this->entidad_id)) {
			mkdir(getcwd()."/img/uploads/sesiones/".$this->entidad_id,0777,true);
		}*/
		$path = getcwd()."/img/uploads/sesiones/".$this->entidad_id."_".$this->nombre;
		if (isset($_FILES["sesion_imagen"]) and $_FILES["sesion_imagen"] and $_FILES["sesion_imagen"]['name']) {
			$archivo = Upload::factory('sesion_imagen');//llamamos a la libreria y le pasamos el nombre del campo file del formulario
            if (!file_exists($path)) {
				mkdir($path,0777,true);
				chmod($path,0777);
				$archivo->setPath($path);

			}else{
				$archivo->setPath($path);
			}
			$_FILES["sesion_imagen"]["name"] = $fecha."_".$_FILES["sesion_imagen"]["name"];
            $archivo->setExtensions(array('jpg', 'png', 'gif','jpeg')); //le asignamos las extensiones a permitir
            if ($archivo->isUploaded()) { 
                if ($archivo->save()) {
                    Flash::valid('Archivo subido correctamente...!!!');
                    $this->imagen = "/uploads/sesiones/".$this->entidad_id."_".$this->nombre."/".$_FILES["sesion_imagen"]["name"];
                }
            }else{
                    Flash::warning('No se ha Podido Subir el Archivo...!!!');
            }
		}
	}
	public function getUltimaId(){
		$s = $this->find("limit: 1","order: id desc");
		return $s[0]->id;
	}
	public function cambioestadosesion($id){
		$s = $this->find($id);
		if ($s->publicado) {
			$s->publicado = null;
		}else{
			$s->publicado = 1;
		}
		if ($s->update()) {
			return true;
		}
		return false;
	}
	public function getSesionByNombre($nombre,$entidad_nombre,$fecha_sesion){

		$entidad = Load::model("entidad")->find_first("conditions: nombre = '$entidad_nombre' ");
		$fecha_sesion = explode("-", $fecha_sesion);
		$fecha_sesion = $fecha_sesion[2].'-'.$fecha_sesion[1]."-".$fecha_sesion[0];
		$r = $this->find_first("conditions: nombre='$nombre' and entidad_id = '{$entidad->id}' and fecha_sesion='$fecha_sesion'");
		//die(Util::pre($r));
		//Util::pre($r); <-- va bien
		return $r;
	}
	public function getSesionesPorAno($entidad_id){
		$sesiones = $this->find("conditions: entidad_id = '$entidad_id'","order: fecha_sesion desc");
		/*echo "<pre>";
		print_r($sesiones);
		echo "</pre>";*/
		if (count($sesiones)) {
			$ano1 = explode("-",$sesiones[0]->fecha_sesion);
			$ano1 = $ano1[0];

			foreach ($sesiones as $key => $value) {
				if ($ano1 != explode("-",$value->fecha_sesion)[0]) {
					$ano1 = explode("-",$value->fecha_sesion)[0];
					$data[$ano1][] = $value->nombre;
				}else{
					$data[$ano1][] = $value->nombre;
				}
			}
			//print_r($data);
			return $data;
		}
	}
	public function getSesionByIdEncriptada($id_encriptada){
		$sesiones = $this->find();
		foreach ($sesiones as $key => $value) {
			if (md5($value->id) == $id_encriptada) {
				return $value;
			}
		}
		return null;
	}
	public function getSesionesByNombreEntidadEncriptado($entidad_encriptado,$ano){

		$nombre_entidad = $this->getEntidadEncriptado($entidad_encriptado);
		$entidad = Load::model("entidad")->getEntidadByNombre($nombre_entidad);
		$id_entidad = $entidad->id;

		$sesiones = $this->find("conditions: entidad_id = '$id_entidad' and fecha_sesion like '$ano%'");
		
		
		$partipaciones =Load::model("participaciones");
		if ($sesiones) {
			foreach ($sesiones as $key => $value) {
				$tiempo = $partipaciones->getMenorHoraBySesionesId($value->id);
				if ($tiempo) {
					$value->tiempo = $tiempo;
				}else{
					$value->tiempo = "--";
				}
			}
		}

		/*esto guarda las partipaciones en la base de datos*/
		Load::model("participaciones")->validarParticipacionesDeSesiones($sesiones);
		return $sesiones;
	}
	public function getEntidadEncriptado($encriptado){
		$entidades = Load::model("entidad")->find();
		foreach ($entidades as $key => $value) {
			if ($encriptado == md5($value->nombre)) {
				return $value->nombre;
			}
		}
		return false;
	}
	
}

 ?>