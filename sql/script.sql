CREATE TABLE instrucciones(
      id TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
      nombre_fichero VARCHAR(100) NOT NULL,
      CONSTRAINT UX_NOMBRE_FICHERO UNIQUE KEY(nombre_fichero)
);

-- Eliminar tabla

DROP TABLE instrucciones;