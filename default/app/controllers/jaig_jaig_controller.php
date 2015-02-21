
<?php 
Load::models("entidad","cliente","sesiones","participaciones","documentos");
class JaigJaigController extends AppController{	
		public function index(){
			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
			$nombre_entidad = Router::get("controller");

		
				$entidad = new Entidad();
				$cliente = new Cliente();
				$sesiones = new Sesiones();
				$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
				$this->cliente = $cliente->getClienteByEntidadId($this->entidad->id);
				
				if (isset($this->entidad->id) and $entidad->validarNombreEntidad($nombre_entidad)) {
					
					$this->sesiones = $sesiones->getSesionesByEntidadId($this->entidad->id,1);
					$this->sesiones_creadas = $sesiones->getSesionesPorAno($this->entidad->id);
		
					$this->obj_participaciones = new Participaciones();
				}
	
			/*echo "<pre>";
			print_r($_POST);
			print_r($_FILES);
			echo "</pre>";*/
			if (Input::haspost("entidad")) {
				/*para evitar el nombre nulo y el logo nulo, y evitar hackeo*/
				$_POST["entidad"]["nombre"]=$this->entidad->nombre;
				$_POST["entidad"]["logo"]=$this->entidad->logo;

				$post = Input::post("entidad");
				$edicion_entidad = new Entidad(Input::post("entidad"));
				if ($edicion_entidad->update()) {
					Flash::valid("Edicion Realizada");
					Input::delete();
					$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
					$this->cliente = $cliente->getClienteByEntidadId($this->entidad->id);
				}else{
					Flash::error("Error");
				}
			}
			if (isset($_FILES["logo"]) and $_FILES["logo"]) {
				

				$entidad_foto = new Entidad();
				$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
				$entidad_foto->editarLogo($this->entidad);
			}
			if (Input::haspost("cliente")) {
				/*para evitar el campos nulos y el logo nulo, y evitar hackeo*/
				$_POST["cliente"]["entidad_id"] = $this->cliente->entidad_id;
				$_POST["cliente"]["id"] = $this->cliente->id;
				$_POST["cliente"]["usuario"] = $this->cliente->usuario;
				$_POST["cliente"]["clave"] = $this->cliente->clave;
				$_POST["cliente"]["participante"] = $this->cliente->participante;

				$cliente = new Cliente(Input::post("cliente"));
				if ($cliente->update()) {
					Flash::valid("Cliente Editado");
					Input::delete();
					$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
					$this->cliente = $cliente->getClienteByEntidadId($this->entidad->id);
				}else{
					Flash::error("Error editando cliente");
				}
			}
			if (Input::haspost("cambio_clave")) {
				if (empty($_POST["clave"]) or empty($_POST["clave_nueva"])) {
					Flash::error("Los campos para las claves son obligatorios por seguridad");
				}else{
					$cliente_clave_nueva = new Cliente();
					$clave_vieja = $cliente_clave_nueva->encriptar(Input::post("clave"));
					$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
					$this->cliente = $cliente->getClienteByEntidadId($this->entidad->id);
					$cliente = $cliente_clave_nueva->find($this->cliente->id);
					if ($clave_vieja != $cliente->clave) {
						Flash::error("Sus Claves anteriores no coinciden");
					}else{
						$clave_nueva = $cliente_clave_nueva->encriptar(Input::post("clave_nueva"));
						$cliente->clave = $clave_nueva;
						if ($cliente->update()) {
							Flash::valid("Clave Cambiada");
							Input::delete();
							$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
							$this->cliente = $cliente->getClienteByEntidadId($this->entidad->id);
						}else{
							Flash::error("Error Cambiando Clave");
						}
					}
				}
			}
			
			
			
		}
		public function cambioestadosesion($id){
			$sesion = new Sesiones();
			View::select(null,"json");
			if($sesion->cambioestadosesion($id)){
				$this->data = array("correcto"=>true,"mensaje"=>ob_get_contents());
			}else{
				$this->data = array("correcto"=>false,"mensaje"=>ob_get_contents());

			}

		}
		public function sesiones($nombre_entidad_encriptado_md5,$ano){
			$nombre_entidad = Router::get("controller");
			$entidad = new Entidad();
			$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
			$sesiones = new Sesiones();
			$this->obj_participaciones = new Participaciones();
			$this->sesiones = $sesiones->getSesionesByNombreEntidadEncriptado($nombre_entidad_encriptado_md5,$ano);
			/*le puse null para que se pueda ver desde el partial y para no crear vistas a cada rato*/
			View::select(null);
			
			View::partial("sesiones",null,array("sesiones"=>$this->sesiones,"obj_participaciones"=>$this->obj_participaciones,"entidad"=>$this->entidad));
		}
		public function participaciones($sesion_id_encriptada){
			$nombre_entidad = Router::get("controller");
			$participaciones = Load::model("participaciones");
			$entidad = new Entidad();
			$sesion = new Sesiones();
			$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
			$sesion_id = $participaciones->getSesionEncriptada($sesion_id_encriptada);
			$this->sesion = $sesion->find($sesion_id);
			View::select(null);
			$this->participationes = $participaciones->getParticipacionesBySesionId($sesion_id,"tiempo asc");
			$documentos = new Documentos();
	
			$this->documentos = $documentos->getDocumentosBySesionId($sesion_id);

			View::partial("participaciones",null,array("participaciones"=>$this->participationes,"entidad"=>$this->entidad,"sesion"=>$this->sesion,"documentos"=>$this->documentos));

		}

		public function cambiarSesionStatus($sesion_id){
			$sesion = Load::model("participaciones");
			View::select(null,"json");
			if ($sesion->cambiarstatus($sesion_id)) {
				$this->data = array("respuesta"=>true);
			}else{
				$this->data = array("respuesta"=>false);

			}
		}
		public function editar_sesion($sesion_id_encriptada){
			$entidad = new Entidad();
			$sesion = new Sesiones();
			$nombre_entidad = Router::get("controller");
			$this->sesion = $sesion->getSesionByIdEncriptada($sesion_id_encriptada);
			if (Input::haspost("sesiones")) {
				$copia = Load::model("sesiones")->find($_POST["sesiones"]["id"]);

				$sesion_obj = new Sesiones(Input::post("sesiones"));
				$sesion_obj->fecha_registro = $copia->fecha_registro;
				$sesion_obj->fecha_sesion = $copia->fecha_sesion;
			
				$sesion_obj->publicado = $copia->publicado;
				$sesion_obj->sesion_abierta = $copia->sesion_abierta;
				$sesion_obj->entidad_id = $copia->entidad_id;
				if (isset($_FILES["archivo"]) and $_FILES["archivo"]["name"]) {
				
					$path = getcwd()."/img/uploads/sesiones/$nombre_entidad/{$this->sesion->nombre}/";
					$archivo = Upload::factory("archivo");//llamamos a la libreria y le pasamos el nombre del campo file del formulario
		            $archivo->setPath($path);
		            $_FILES["archivo"]["name"] = date("Y-m-d_h-i-s")."_".$_FILES["archivo"]["name"];
		            $archivo->setExtensions(array("jpeg","jpg", "png", "gif")); //le asignamos las extensiones a permitir
		            if ($archivo->isUploaded()) { 
		                if ($archivo->save()) {
		                	
		                		$sesion_obj->imagen = "uploads/sesiones/$nombre_entidad/{$this->sesion->nombre}/".$_FILES["archivo"]["name"];
		                		if ($copia->imagen and !unlink(getcwd()."/img/".$copia->imagen)) {
		                			Flash::error("error Borrando la imagen anterior");
		                		}
		                	
		                    Flash::valid("Archivo subido correctamente...!!!");
		                }
		            }else{
		                    Flash::warning("No se ha Podido Subir el Archivo...!!!");
		            }
				}else{
					$sesion_obj->imagen = $copia->imagen;
		
				}
				if (!$sesion_obj->update()) {
					Flash::error("Error actualizando sesion");
				}else{
					Flash::valid("Sesion actualizada");
				}
			}
			$documentos = new Documentos();
			if (Input::post("documentos_ocultos")) {

				$documentos->subirDocumentos($this->sesion->id);
			}
			$this->entidad = $entidad->getEntidadByNombre($nombre_entidad);
			$this->documentos = $documentos->getDocumentosBySesionId($this->sesion->id);
			View::select(null);
			View::partial("editar_sesion",null,array("entidad"=>$this->entidad,"sesiones"=>$this->sesion,"documentos"=>$this->documentos));
		}

}
?>	
		