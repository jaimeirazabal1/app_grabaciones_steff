<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends AppController
{

    public function index($entidad=null)
    {
        die("nombre de la entidad: ".$entidad);
    }


}
