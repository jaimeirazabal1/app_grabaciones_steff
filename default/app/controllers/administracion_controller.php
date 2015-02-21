<?php 
Load::models("entidad","sesiones");
class AdministracionController extends AppController{
	public function index(){
		$entity = new Entidad();
		$this->sesiones_objeto = new Sesiones();
		$this->entidades = $entity->getEntidadesConCliente();
	}
}
 ?>