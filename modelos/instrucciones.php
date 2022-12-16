<?php
    class InstruccionesModelo{

        function __construct($config){
            $this->conexion = new mysqli($config['servidor'], $config['usuario'], $config['contrasena'], $config['database']);
            $this->conexion->set_charset('utf8');
        }

        function consultarDatos(){
            $sql = "SELECT * FROM instrucciones";
            $resultado = $this->conexion->query($sql);
            return $resultado;
        }

        function insertarDatos($nombreFichero){
            $sql = "INSERT INTO instrucciones VALUES(default, ?)";
            $resultado = $this->conexion->prepare($sql);
            $resultado->bind_param('s', $nombreFichero);
            $resultado->execute();
        }

        function eliminarDatos($id){
            $sql = "DELETE FROM instrucciones WHERE id = ?";
            $resultado = $this->conexion->prepare($sql);
            $resultado->bind_param('i', $id);
            $resultado->execute();
        }

        function modificarDatos($id, $nombre){
            $sql = "UPDATE instrucciones SET nombre_fichero = ? WHERE id = ?";
            $resultado = $this->conexion->prepare($sql);
            $resultado->bind_param('si', $nombre, $id);
            $resultado->execute();
        }

}
