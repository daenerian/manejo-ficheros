<?php
    $config = require_once('config/config.php');

    try{
        session_start();
        $usuario = NULL;

        if(isset($_SESSION['usuario'])){
            $usuario = $_SESSION['usuario'];
        }

        $pathParams = [];
        if(isset($_SERVER['PATH_INFO'])){
            $pathParams = explode('/', $_SERVER['PATH_INFO']);
        }

        require_once ($config['path_controladores']).'instrucciones.php';
        $controlador = new Instrucciones($config);

        if(count($pathParams)<1){
            $controlador->listarDatos();
            die();
        }

        $queryParams = NULL;
        parse_str($_SERVER['QUERY_STRING'], $queryParams);

        $metodo = $pathParams[1];

        switch($metodo){
            case 'agregarInstrucciones':
                $controlador->mostrarFormularioAgregar();
                break;
            case 'actualizarDato':
                $controlador->mostrarFormularioModificar($queryParams);
                break;
            case 'insertarDato':
                $controlador->insertarDato();
                break;
            case 'modificarDato':
                $controlador->modificarDato($queryParams);
                break;
            case 'consultarDato':
                $controlador->consultarDato($queryParams);
                break;
            case 'eliminarDato':
                $controlador->eliminarDato($queryParams);
                break;
            default:
                header('HTTP/1.1 501 Not Implemented');
        }


    }
    catch (ErrorException $e){
        header('HTTP/1.1 500 Internal Server Error');
    }