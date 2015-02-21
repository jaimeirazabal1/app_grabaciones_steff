<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AppController extends Controller
{

    final protected function initialize()
    {	

    	$controlador = Router::get("controller");
    	$accion = Router::get("action");
    	$ruta = $controlador."/".$accion;
        if (!Auth::is_valid() and $ruta != "cliente/login") {
    		Flash::info("Debe ser usuario autenticado");
    		Router::redirect("cliente/login");
    	}else{
    		$rutas_admin = array("cliente/crear","entidad/crear");

    		if (in_array($ruta, $rutas_admin) and Auth::get("role") != "admin" ) {
    			Flash::info("No posee suficientes privilegios");
    			Router::redirect("cliente/login");
    		}
    	}
    }

    final protected function finalize()
    {
        
    }

}
