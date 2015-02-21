<?php 
Load::models("sesiones");
class Documentos extends ActiveRecord{
	public function subirDocumentos($sesion_id){
		$this->validarDirectoriosDocumentos($sesion_id);
		 $i = 0;

		foreach($_FILES['documentos'] as $file) 
        {
        	if (isset($_FILES["documentos"]["name"][$i])) {
        		# code...
	        	//Flash::valid($i);
	            //si se está subiendo algún archivo en ese indice
	            if($_FILES['documentos']['tmp_name'][$i])
	            {
	                //separamos los trozos del archivo, nombre extension
	                $trozos[$i] = explode(".", $_FILES["documentos"]["name"][$i]);
	 
	                //obtenemos la extension
	                $extension[$i] = end($trozos[$i]);
	 
	                //si la extensión es una de las permitidas
	                if($this->checkExtension($extension[$i]) === TRUE)
	                {    
	 
	                    //comprobamos si el archivo ha subido
	                    $nombre_doc_aux = $_FILES['documentos']['name'][$i];
	                    $_FILES['documentos']['name'][$i] = date("Y-m-d_H-i-s_").$_FILES['documentos']['name'][$i];
	                    $ruta = $this->getRutaParaDocumentos($sesion_id);
	                    if(move_uploaded_file($_FILES['documentos']['tmp_name'][$i],$ruta.$_FILES['documentos']['name'][$i]))
	                    {
	                        Flash::valid( "subida correctamente el documento ".$nombre_doc_aux);
	                        chmod($ruta.$_FILES['documentos']['name'][$i],0777);
	                        $doc = new Documentos();
	                        $doc->sesiones_id = $sesion_id;
	                        $sesiones = new Sesiones();
							$s = $sesiones->find($sesion_id);
							$nombre_sesion = $this->cambiarFecha($s->fecha_sesion).".".$s->nombre;
							$nombre_entidad = Router::get("controller");
	                        $doc->adjunto = "files/uploads/$nombre_entidad/$nombre_sesion/documentos/".$_FILES['documentos']['name'][$i];
	                        $doc->nombre = $nombre_doc_aux;
	                        if (!$doc->save()) {
	                        	Flash::error("Error registrando el documento ".$nombre_doc_aux);
	                        }
	                        //aqui podemos procesar info de la bd referente a este archivo
	                    } else{
	                    	$errores[]=array($_FILES['documentos']['name'][$i]);
	                    }
	                //si la extension no es una de las permitidas
	                }else{
	                    Flash::error("la extension de ".$_FILES['documentos']['name'][$i]." no esta permitida");
	                }
	            //si ese input file no ha sido cargado con un archivo
	            }
	            
	            //en cada pasada por el loop incrementamos i para acceder al siguiente archivo
	            $i++;     
        	}
        }   
	}
	public function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("doc","docx");
        if(in_array(strtolower($extension), $extensiones))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
	public function getRutaParaDocumentos($sesion_id){
		$sesiones = new Sesiones();
		$s = $sesiones->find($sesion_id);
		$nombre_sesion = $this->cambiarFecha($s->fecha_sesion).".".$s->nombre;
		$nombre_entidad = Router::get("controller");
		$path = getcwd()."/files/uploads/$nombre_entidad/$nombre_sesion/documentos/";
		return $path;
	}
	public function validarDirectoriosDocumentos($sesion_id){
		/*
			FORMATO DE DIRECTORIO : 12-01-2015.Sesion Extraordinaria
		*/
		$sesiones = new Sesiones();
		$s = $sesiones->find($sesion_id);
		$nombre_sesion = $this->cambiarFecha($s->fecha_sesion).".".$s->nombre;
		$nombre_entidad = Router::get("controller");
		$path = getcwd()."/files/uploads/$nombre_entidad/$nombre_sesion/documentos/";
		if (!is_dir($path)) {
			
			mkdir($path,0777,true);
		
			chmod($path,0777);
			return true;
		}
		return null;
	}
	public function cambiarFecha($fecha) {
	  return implode("-", array_reverse(explode("-", $fecha)));
	} 
	public function getDocumentosBySesionId($sesion_id){

		return $this->find("conditions: sesiones_id = '$sesion_id'");
	}
}

?>