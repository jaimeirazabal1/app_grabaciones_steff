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
        /*----------------------------------------------------------------*/
        /*----------------------------------------------------------------*/
        /*----------------------------------------------------------------*/
        /*aqui pones las rutas a las que quieres que todo el mundo ingrese*/
        /*esta condicion la hice porque necitabas que cualquiera entrara al index
        de cualquier controlador. Pero hay una exception, no puede entrar al index
        de el controlador administracion*/
        if ($controlador!='administracion') {
            $rutas_publicas = array("cliente/login","index/index",$controlador."/index",$controlador."/sesiones",$controlador."/participaciones");
        }else{
            $rutas_publicas = array("cliente/login","index/index");
        }
        /*----------------------------------------------------------------*/
        /*----------------------------------------------------------------*/
        /*----------------------------------------------------------------*/
        /*----------------------------------------------------------------*/

        $ruta = $controlador."/".$accion;

        //die($ruta);
        if (!Auth::is_valid() and !in_array($ruta, $rutas_publicas)) {
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
