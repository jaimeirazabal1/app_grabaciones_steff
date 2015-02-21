<?php 
Load::models("entidad");
Class EntidadController extends AppController{
	public function crear(){
		if (Input::haspost("entidad")) {			
			$entidad = new Entidad(Input::post("entidad"));
			$entidad->nombre = str_replace(' ', '_', $entidad->nombre);
			$entidad->setRutaCarpeta();
			if (Input::haspost("logo")) {
				$entidad->subirLogo();
			}
			if ($entidad->save()) {
				Flash::valid("Entidad Registrada");
				
				$entidad_id = $entidad->getUltimaEntidad();
				$_entidad = new Entidad();
				$_entidad->mkEntidadController($entidad->nombre);
				//se manda el id de la entidad para crear el usuario y asociarlo con su entidad creada;
				Router::redirect("cliente/crear/".$entidad_id);
			}else{
				Flash::error("Entidad no Registrada");
			}
		}
	}
}

 ?>