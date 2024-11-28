CREATE SCHEMA tienda_bd;

USE tienda_bd;

CREATE TABLE categorias(
	categoria VARCHAR(30) PRIMARY KEY,
    descripcion VARCHAR(255)
);

CREATE TABLE productos(
	id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    precio NUMERIC(6,2),
    categoria VARCHAR(30),
    stock INT DEFAULT 0,
    imagen VARCHAR(60),
    descripcion VARCHAR(255),
    FOREIGN KEY (categoria) REFERENCES categorias(categoria)
);

CREATE TABLE usuarios(
	nombre_usuario VARCHAR(15) PRIMARY KEY,
    constrasena VARCHAR(15)
);

select * from usuarios;