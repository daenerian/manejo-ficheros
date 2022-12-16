<?php

    class Instrucciones{

        function __construct($config){
            require_once $config['path_modelos'].'instrucciones.php';
            require_once $config['path_vistas'].'instruccionesVista.php';
            $this->modelo = new InstruccionesModelo($config);
            $this->vista = new instruccionesVista($config);
            $this->directorio = 'ficheros/';
        }

        function listarDatos(){
           $data = $this->modelo->consultarDatos();
           $this->vista->mostrarInicio($data);
//            header('Location: index.php/mostrarFormularioAgregar');
        }

        function mostrarFormularioAgregar(){
            $this->vista->mostrarFormulario();
        }

        function mostrarFormularioModificar($parametros){
            $this->vista->mostrarFormularioDatos($parametros);
        }

        function insertarDato(){
            if($_FILES['fichero']['type'] == 'application/pdf'){
                $nombreFichero = $_POST['nombre-fichero'];
                $this->cargarFichero($nombreFichero);
                $this->modelo->insertarDatos($nombreFichero);
                header('Refresh:0; url=../');
            }else{
                echo 'No has seleccionado un fichero tipo PDF';
                header('Refresh:2; url=../index.php/agregarInstrucciones');
            }
        }

        function modificarDato($parametros){
            $nombreFichero = $_POST['nombre-fichero'];
            if(!empty($_FILES['fichero']['name'])){
                if($_FILES['fichero']['type'] == 'application/pdf') {
                    $this->eliminarFichero($parametros);
                    $this->cargarFichero($nombreFichero);
                    $this->modelo->modificarDatos($parametros['id'], $nombreFichero);
                    header('Refresh:0; url=../');
                }else{
                    echo 'No has seleccionado un fichero tipo PDF';
                    header('Refresh:2; url=../index.php/actualizarDato?id='.$parametros['id'].'&nombre='.$parametros['nombre']);
                }
            }
            else{
                $this->renombrarFichero($parametros, $nombreFichero);
                $this->modelo->modificarDatos($parametros['id'], $nombreFichero);
                header('Refresh:0; url=../');
            }
        }

        function eliminarDato($parametros){
            $this->modelo->eliminarDatos($parametros['id']);
            $this->eliminarFichero($parametros);
            header('Refresh:0; url=../');
        }

        function cargarFichero($nombreFichero){
            move_uploaded_file($_FILES['fichero']['tmp_name'], $this->directorio.$nombreFichero.'.pdf');
        }

        function eliminarFichero($parametros){
            $ruta = $this->directorio.$parametros['nombre'].'.pdf';
            if(file_exists($ruta)){
                unlink($ruta);
            }
        }

        function renombrarFichero($parametros, $nombreFichero){
            $rutaOriginal = $this->directorio.$parametros['nombre'].'.pdf';
            $rutaNuevo = $this->directorio.$nombreFichero.'.pdf';
            if(file_exists($rutaOriginal)){
                rename($rutaOriginal, $rutaNuevo);
            }
        }

    }
