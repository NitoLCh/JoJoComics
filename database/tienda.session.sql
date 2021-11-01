CREATE TABLE cliente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(10) UNIQUE,
    calle VARCHAR(255),
    ciudad VARCHAR(255),
    estado VARCHAR(255),
    cp VARCHAR(5)
);

--@block
CREATE TABLE pedido(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    estado VARCHAR(255) NOT NULL,
    fecha_orden DATE NOT NULL,
    fecha_entrega DATE
    FOREIGN KEY(id_cliente) REFERENCES cliente(id)
);

