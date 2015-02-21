<?php 
class Cliente extends ActiveRecord{
	public function encriptar($clave = null){
		if ($clave) {
			return md5($clave);
		}
		if ($this->clave) {
			$this->clave = md5($this->clave);
		}
	}
	protected function initialize(){
    	$this->validates_uniqueness_of("cedula");
    	$this->validates_uniqueness_of("usuario");
   	}
	public function getClienteById($id){
		return $this->find($id);
	}
	public function impresionHtml($cliente){
		return
		"<table><tr><td>Nombre:</td><td>" .$cliente->nombre."</td></tr>".
		"<tr><td>Apellido:</td><td>" .$cliente->apellido."</td></tr>".
		"<tr><td>Usuario:</td><td>" .$cliente->usuario."</td></tr>".
		"<tr><td>Participante:</td><td>" .$cliente->usuario."</td></tr>".
		"<tr><td>Cod Acceso:</td><td>" .$cliente->cod_acceso."</td></tr></table>";
	}
	public function getClienteByEntidadId($id){
		$query = "select cliente.* from cliente inner join entidad on entidad.id = cliente.entidad_id and entidad.id = '$id'";
		return $this->find_by_sql($query);
	}
	public function iniciarComoParticipante($participante,$cod_acceso){

		$auth = new Auth("model", "class: cliente", "participante: $participante", "cod_acceso: $cod_acceso");
        if ($auth->authenticate()) {
        	$_SESSION['KUMBIA_AUTH_IDENTITY']['default']['role'] =  "participante";
        	$entidad = Load::model("entidad");
        	$entity = $entidad->getEntidadByClienteId(Auth::get("id"));
            Router::redirect($entity->nombre."/");
            return true;
        }else{
           return false;
        }
	}
}

 ?>