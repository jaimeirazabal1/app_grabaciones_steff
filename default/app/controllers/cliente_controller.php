<?php 
Load::models("cliente","entidad","role");
Class ClienteController extends AppController{
	
	public function crear($entidad = null){
		if ($entidad) {
			$this->entidad = $entidad;
			if (Input::haspost("cliente")) {
				$cliente = new Cliente(Input::post("cliente"));
				$cliente->encriptar();
				if ($cliente->save()) {
					Flash::valid("Cliente creado");
					Flash::info(
						$cliente->impresionHtml($cliente)
						);
					Input::delete();
				}else{
					Flash::error("El cliente no ha sido Creado");
				}
			}
		}else{
			Flash::error("No se Mando una entidad, por favor crear una");
			Router::redirect("entidad/crear");
		}
	}
	public function login(){
		View::template("administracion");
		if (Input::haspost("cliente")){
			$cliente = new Cliente();
			$post = Input::post("cliente");
			if (!$cliente->iniciarComoParticipante($post['usuario'],$post['clave'])) {
	            $pwd = $cliente->encriptar($post['clave']);
	            $usuario=$post['usuario'];
	            $auth = new Auth("model", "class: cliente", "usuario: $usuario", "clave: $pwd");
	            $r = new Role();
	            if ($auth->authenticate()) {
	            	$_SESSION['KUMBIA_AUTH_IDENTITY']['default']['role'] = isset($r->getRoleById(Auth::get("role_id"))->role) ? $r->getRoleById(Auth::get("role_id"))->role : null;
	            	$entidad = new Entidad();
	            	$entity = $entidad->getEntidadByClienteId(Auth::get("id"));
	            	if (Auth::get("role") == "admin") {
	            		Router::redirect("administracion/");
	            	}else{
	                	Router::redirect($entity->nombre."/");
	            	}
	            } else {
	                Flash::error("Falló");
	            }
			}
        }
	}
	public function logout(){
		Auth::destroy_identity();
		Router::toAction("login");
	}
}

 ?>