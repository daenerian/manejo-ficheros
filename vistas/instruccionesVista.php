<?php

    class instruccionesVista{

        function __construct($config){
            $this->config = $config;
        }

        function mostrarInicio($data){
            $doc = new DOMDocument();
            @$doc->loadHTMLFile($this->config['path_html'].'inicio.html');
            $tabla = $doc->getElementById('cuerpo-instrucciones');
            while($datos = $data->fetch_object()){
                $fila = $doc->createElement('tr');
                $nombre = $doc->createElement('td');
                $nombre->appendChild($doc->createTextNode($datos->nombre_fichero));
                $operaciones = $doc->createElement('td');
                $linkModificar = $doc->createElement('a');
                $linkModificar->setAttribute('href', 'index.php/actualizarDato?id='.$datos->id.'&nombre='.$datos->nombre_fichero);
                $botonModificar = $doc->createElement('div');
                $botonModificar->setAttribute('class', 'fa-solid fa-pen');
                $linkModificar->appendChild($botonModificar);
                $operaciones->appendChild($linkModificar);

                $linkEliminar = $doc->createElement('a');
                $linkEliminar->setAttribute('href', 'index.php/eliminarDato?id='.$datos->id.'&nombre='.$datos->nombre_fichero);
                $botonEliminar = $doc->createElement('div');
                $botonEliminar->setAttribute('class', 'fa-solid fa-trash');
                $linkEliminar->appendChild($botonEliminar);
                $operaciones->appendChild($linkEliminar);
                $fila->appendChild($nombre);
                $fila->appendChild($operaciones);
                $tabla->appendChild($fila);
            }
            echo $doc->saveHTML();
        }

        function mostrarFormulario(){
            $doc = new DOMDocument();
            @$doc->loadHTMLFile($this->config['path_html'].'formulario.html');
            $formulario = $doc->getElementById('formulario-instrucciones');
            $formulario->setAttribute('action', 'insertarDato');
            echo $doc->saveHTML();
        }

        function mostrarFormularioDatos($parametros){
            $doc = new DOMDocument();
            @$doc->loadHTMLFile($this->config['path_html'].'formulario.html');
            $mensaje = $doc->getElementById('mensaje-modificar');
            $mensaje->removeAttribute('hidden');
            $formulario = $doc->getElementById('formulario-instrucciones');
            $mostrarFichero = $doc->getElementById('mostrar-pdf');
            $mostrarFichero->removeAttribute('hidden');
            $mostrarFichero->setAttribute('src', '../ficheros/'.$parametros['nombre'].'.pdf');
//            $enlaceFichero = $doc->getElementById('enlace-pdf');
//            $enlaceFichero->setAttribute('href', '../ficheros/'.$parametros['nombre'].'.pdf');
//            $enlaceFichero->appendChild($doc->createTextNode($parametros['nombre'].'.pdf'));
            $nombreFichero = $doc->getElementById('nombre-fichero');
            $nombreFichero->setAttribute('value', $parametros['nombre']);
            $formulario->setAttribute('action', 'modificarDato?id='.$parametros['id'].'&nombre='.$parametros['nombre']);
            echo $doc->saveHTML();
        }

    }
