CREATE TABLE `Usuarios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT (CURRENT_DATE),
  `estado` bool NOT NULL DEFAULT true
  `intentos_login` int NOT NULL DEFAULT 0,
  'ultimo_intento' timestamp NULL
);

CREATE TABLE `HIstorialContrasenias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `contrasenia_hash` varchar(255) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `Contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `tipo_contacto` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `es_principal` bool NOT NULL DEFAULT false,
  UNIQUE (`id_usuario`, `tipo_contacto`, `valor`)
);

CREATE TABLE `Roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) UNIQUE NOT NULL,
  `descripcion` varchar(255)
);

CREATE TABLE `Permisos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) UNIQUE NOT NULL,
  `descripcion` varchar(255),
  `estado` bool DEFAULT true
);

CREATE TABLE `RolPermiso` (
  `id_rol` int,
  `id_permiso` int,
  PRIMARY KEY (`id_rol`, `id_permiso`) 
);

CREATE TABLE `UsuarioRol` (
  `id_usuario` int,
  `id_rol` int,
  PRIMARY KEY (`id_usuario`, `id_rol`)
);

CREATE TABLE `Propiedades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL, 
  `latitud` numeric(9,6) NOT NULL,
  `longitud` numeric(9,6) NOT NULL,
  `precio` numeric(12,2) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `superficie_total` decimal(10,2) NOT NULL, 
  `num_habitaciones` int,
  `num_banos` int,
  `imagenes` varchar(50), -- Aumentado a 255 por si quieres guardar una URL completa
  `estado` varchar(15),
  `fecha_publicacion` date NOT NULL DEFAULT (CURRENT_DATE),
  `fecha_actualizacion` date NOT NULL DEFAULT (CURRENT_DATE)
);
-- Nota sobre 'imagenes' en Propiedades: Si planeas guardar múltiples URLs o URLs muy largas,
-- considera una tabla separada 'Propiedad_Imagenes' para una mejor normalización y flexibilidad.

CREATE TABLE `Etiquetas` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) UNIQUE NOT NULL
);

CREATE TABLE `PropiedadEtiqueta` (
  `id_propiedad` int NOT NULL,
  `id_etiqueta` int NOT NULL,
  PRIMARY KEY (`id_propiedad`, `id_etiqueta`)
);

CREATE TABLE `Denuncias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_propiedad` int NOT NULL,
  `id_usuario` int NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `descripcion` varchar(500),
  `fecha_denuncia` date NOT NULL DEFAULT (CURRENT_DATE),
  `estado` ENUM('pendiente', 'revisada', 'resuelta', 'rechazada') NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE `AuditoriaDB` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fecha_cambio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(50),
  `tabla` varchar(50) NOT NULL,
  `tipo_operacion` varchar(15) NOT NULL,
  `datos_anteriores` json,
  `datos_nuevos` json
);

CREATE TABLE `AuditoriaAPP` (
  `id` int PRIMARY PRIMARY KEY AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(50) NOT NULL,
  `operacion` varchar(255) NOT NULL,
  `resultado` varchar(50),
  `ip_origen` varchar(50)
);

CREATE TABLE `NormativasContrasenias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `longitud_minima` int NOT NULL,
  `longitud_maxima` int NOT NULL,
  `requiere_mayusculas` bool NOT NULL DEFAULT false,
  `requiere_minusculas` bool NOT NULL DEFAULT false,
  `requiere_numeros` bool NOT NULL DEFAULT false,
  `requiere_simbolos` bool NOT NULL DEFAULT false,
  `caducidad_dias` int,
  `intentos_maximos` int,
  `es_activa` bool NOT NULL DEFAULT true,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `HIstorialContrasenias` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`);
ALTER TABLE `Contacto` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`);
ALTER TABLE `Rol_Permiso` ADD FOREIGN KEY (`id_rol`) REFERENCES `Roles` (`id`);
ALTER TABLE `Rol_Permiso` ADD FOREIGN KEY (`id_permiso`) REFERENCES `Permisos` (`id`);
ALTER TABLE `UsuarioRol` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`);
ALTER TABLE `UsuarioRol` ADD FOREIGN KEY (`id_rol`) REFERENCES `Roles` (`id`);
ALTER TABLE `Propiedades` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`);
-- ALTER TABLE `ImgenesPropiedad` ADD FOREIGN KEY (`id_propiedad`) REFERENCES `Propiedades` (`id`); -- Esta línea ha sido comentada/eliminada
ALTER TABLE `PropiedadEtiqueta` ADD FOREIGN KEY (`id_propiedad`) REFERENCES `Propiedades` (`id`);
ALTER TABLE `PropiedadEtiqueta` ADD FOREIGN KEY (`id_etiqueta`) REFERENCES `Etiquetas` (`id`);
ALTER TABLE `Denuncias` ADD FOREIGN KEY (`id_propiedad`) REFERENCES `Propiedades` (`id`);
ALTER TABLE `Denuncias` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`);


-----------------------------------------------------------------------------------------------


-- Función auxiliar (conceptual, no es un stored function en este caso)
-- para generar el JSON a partir de OLD o NEW.
-- En MySQL, esto se hace directamente dentro del TRIGGER.

-- 1. Trigger para la tabla `Usuarios`
DELIMITER $$
CREATE TRIGGER trg_aud_usuarios_insert
AFTER INSERT ON Usuarios
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Usuarios',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'apellido', NEW.apellido,
            'email', NEW.email,
            'fecha_registro', NEW.fecha_registro,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_usuarios_update
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Usuarios',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'apellido', OLD.apellido,
            'email', OLD.email,
            'fecha_registro', OLD.fecha_registro,
            'estado', OLD.estado
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'apellido', NEW.apellido,
            'email', NEW.email,
            'fecha_registro', NEW.fecha_registro,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_usuarios_delete
AFTER DELETE ON Usuarios
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Usuarios',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'apellido', OLD.apellido,
            'email', OLD.email,
            'fecha_registro', OLD.fecha_registro,
            'estado', OLD.estado
        )
    );
END$$
DELIMITER ;

-- 2. Trigger para la tabla `HIstorialContrasenias` (normalmente solo INSERT)
DELIMITER $$
CREATE TRIGGER trg_aud_historialcontrasenias_insert
AFTER INSERT ON HIstorialContrasenias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'HIstorialContrasenias',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'id_usuario', NEW.id_usuario,
            'fecha_cambio', NEW.fecha_cambio
        )
    );
END$$
DELIMITER ;

-- 3. Trigger para la tabla `Contacto`
DELIMITER $$
CREATE TRIGGER trg_aud_contacto_insert
AFTER INSERT ON Contacto
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Contacto',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'id_usuario', NEW.id_usuario,
            'tipo_contacto', NEW.tipo_contacto,
            'valor', NEW.valor,
            'es_principal', NEW.es_principal
        )
    );
END$$

CREATE TRIGGER trg_aud_contacto_update
AFTER UPDATE ON Contacto
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Contacto',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_usuario', OLD.id_usuario,
            'tipo_contacto', OLD.tipo_contacto,
            'valor', OLD.valor,
            'es_principal', OLD.es_principal
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'id_usuario', NEW.id_usuario,
            'tipo_contacto', NEW.tipo_contacto,
            'valor', NEW.valor,
            'es_principal', NEW.es_principal
        )
    );
END$$

CREATE TRIGGER trg_aud_contacto_delete
AFTER DELETE ON Contacto
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Contacto',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_usuario', OLD.id_usuario,
            'tipo_contacto', OLD.tipo_contacto,
            'valor', OLD.valor,
            'es_principal', OLD.es_principal
        )
    );
END$$
DELIMITER ;

-- 4. Trigger para la tabla `Roles`
DELIMITER $$
CREATE TRIGGER trg_aud_roles_insert
AFTER INSERT ON Roles
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Roles',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'descripcion', NEW.descripcion
        )
    );
END$$

CREATE TRIGGER trg_aud_roles_update
AFTER UPDATE ON Roles
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Roles',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'descripcion', OLD.descripcion
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'descripcion', NEW.descripcion
        )
    );
END$$

CREATE TRIGGER trg_aud_roles_delete
AFTER DELETE ON Roles
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Roles',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'descripcion', OLD.descripcion
        )
    );
END$$
DELIMITER ;

-- 5. Trigger para la tabla `Permisos`
DELIMITER $$
CREATE TRIGGER trg_aud_permisos_insert
AFTER INSERT ON Permisos
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Permisos',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'descripcion', NEW.descripcion,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_permisos_update
AFTER UPDATE ON Permisos
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Permisos',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'descripcion', OLD.descripcion,
            'estado', OLD.estado
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'nombre', NEW.nombre,
            'descripcion', NEW.descripcion,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_permisos_delete
AFTER DELETE ON Permisos
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Permisos',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'nombre', OLD.nombre,
            'descripcion', OLD.descripcion,
            'estado', OLD.estado
        )
    );
END$$
DELIMITER ;

-- 6. Trigger para la tabla `Rol_Permiso`
DELIMITER $$
CREATE TRIGGER trg_aud_rolpermiso_insert
AFTER INSERT ON Rol_Permiso
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Rol_Permiso',
        'INSERT',
        JSON_OBJECT(
            'id_rol', NEW.id_rol,
            'id_permiso', NEW.id_permiso
        )
    );
END$$

CREATE TRIGGER trg_aud_rolpermiso_delete
AFTER DELETE ON Rol_Permiso
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Rol_Permiso',
        'DELETE',
        JSON_OBJECT(
            'id_rol', OLD.id_rol,
            'id_permiso', OLD.id_permiso
        )
    );
END$$
DELIMITER ;

-- 7. Trigger para la tabla `UsuarioRol`
DELIMITER $$
CREATE TRIGGER trg_aud_usuariorol_insert
AFTER INSERT ON UsuarioRol
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'UsuarioRol',
        'INSERT',
        JSON_OBJECT(
            'id_usuario', NEW.id_usuario,
            'id_rol', NEW.id_rol
        )
    );
END$$

CREATE TRIGGER trg_aud_usuariorol_update
AFTER UPDATE ON UsuarioRol
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'UsuarioRol',
        'UPDATE',
        JSON_OBJECT(
            'id_usuario', OLD.id_usuario,
            'id_rol', OLD.id_rol
        ),
        JSON_OBJECT(
            'id_usuario', NEW.id_usuario,
            'id_rol', NEW.id_rol
        )
    );
END$$

CREATE TRIGGER trg_aud_usuariorol_delete
AFTER DELETE ON UsuarioRol
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'UsuarioRol',
        'DELETE',
        JSON_OBJECT(
            'id_usuario', OLD.id_usuario,
            'id_rol', OLD.id_rol
        )
    );
END$$
DELIMITER ;

-- 8. Trigger para la tabla `Propiedades`
DELIMITER $$
CREATE TRIGGER trg_aud_propiedades_insert
AFTER INSERT ON Propiedades
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Propiedades',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'id_usuario', NEW.id_usuario,
            'titulo', NEW.titulo,
            'precio', NEW.precio,
            'direccion', NEW.direccion,
            'estado', NEW.estado
            -- Se pueden añadir más campos según la relevancia
        )
    );
END$$

CREATE TRIGGER trg_aud_propiedades_update
AFTER UPDATE ON Propiedades
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Propiedades',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_usuario', OLD.id_usuario,
            'titulo', OLD.titulo,
            'precio', OLD.precio,
            'direccion', OLD.direccion,
            'superficie_total', OLD.superficie_total,
            'num_habitaciones', OLD.num_habitaciones,
            'num_banos', OLD.num_banos,
            'imagenes', OLD.imagenes,
            'estado', OLD.estado
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'id_usuario', NEW.id_usuario,
            'titulo', NEW.titulo,
            'precio', NEW.precio,
            'direccion', NEW.direccion,
            'superficie_total', NEW.superficie_total,
            'num_habitaciones', NEW.num_habitaciones,
            'num_banos', NEW.num_banos,
            'imagenes', NEW.imagenes,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_propiedades_delete
AFTER DELETE ON Propiedades
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Propiedades',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_usuario', OLD.id_usuario,
            'titulo', OLD.titulo,
            'precio', OLD.precio,
            'direccion', OLD.direccion,
            'superficie_total', OLD.superficie_total,
            'num_habitaciones', OLD.num_habitaciones,
            'num_banos', OLD.num_banos,
            'imagenes', OLD.imagenes,
            'estado', OLD.estado
        )
    );
END$$
DELIMITER ;

-- 9. Trigger para la tabla `Denuncias`
DELIMITER $$
CREATE TRIGGER trg_aud_denuncias_insert
AFTER INSERT ON Denuncias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Denuncias',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'id_propiedad', NEW.id_propiedad,
            'id_usuario', NEW.id_usuario,
            'motivo', NEW.motivo,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_denuncias_update
AFTER UPDATE ON Denuncias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Denuncias',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_propiedad', OLD.id_propiedad,
            'id_usuario', OLD.id_usuario,
            'motivo', OLD.motivo,
            'estado', OLD.estado
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'id_propiedad', NEW.id_propiedad,
            'id_usuario', NEW.id_usuario,
            'motivo', NEW.motivo,
            'estado', NEW.estado
        )
    );
END$$

CREATE TRIGGER trg_aud_denuncias_delete
AFTER DELETE ON Denuncias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'Denuncias',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'id_propiedad', OLD.id_propiedad,
            'id_usuario', OLD.id_usuario,
            'motivo', OLD.motivo,
            'estado', OLD.estado
        )
    );
END$$
DELIMITER ;

-- 11. Trigger para la tabla `NormativasContrasenias`
DELIMITER $$
CREATE TRIGGER trg_aud_normativascontrasenias_insert
AFTER INSERT ON NormativasContrasenias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'NormativasContrasenias',
        'INSERT',
        JSON_OBJECT(
            'id', NEW.id,
            'longitud_minima', NEW.longitud_minima,
            'requiere_mayusculas', NEW.requiere_mayusculas,
            'caducidad_dias', NEW.caducidad_dias,
            'es_activa', NEW.es_activa
        )
    );
END$$

CREATE TRIGGER trg_aud_normativascontrasenias_update
AFTER UPDATE ON NormativasContrasenias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores, datos_nuevos)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'NormativasContrasenias',
        'UPDATE',
        JSON_OBJECT(
            'id', OLD.id,
            'longitud_minima', OLD.longitud_minima,
            'requiere_mayusculas', OLD.requiere_mayusculas,
            'caducidad_dias', OLD.caducidad_dias,
            'es_activa', OLD.es_activa
        ),
        JSON_OBJECT(
            'id', NEW.id,
            'longitud_minima', NEW.longitud_minima,
            'requiere_mayusculas', NEW.requiere_mayusculas,
            'caducidad_dias', NEW.caducidad_dias,
            'es_activa', NEW.es_activa
        )
    );
END$$

CREATE TRIGGER trg_aud_normativascontrasenias_delete
AFTER DELETE ON NormativasContrasenias
FOR EACH ROW
BEGIN
    INSERT INTO AuditoriaDB (fecha_cambio, usuario, tabla, tipo_operacion, datos_anteriores)
    VALUES (
        NOW(),
        CURRENT_USER(),
        'NormativasContrasenias',
        'DELETE',
        JSON_OBJECT(
            'id', OLD.id,
            'longitud_minima', OLD.longitud_minima,
            'requiere_mayusculas', OLD.requiere_mayusculas,
            'caducidad_dias', OLD.caducidad_dias,
            'es_activa', OLD.es_activa
        )
    );
END$$
DELIMITER ;