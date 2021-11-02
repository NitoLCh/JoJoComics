USE jojo_comics;

--@block
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
    fecha_entrega DATE,
    FOREIGN KEY(id_cliente) REFERENCES cliente(id)
);

--@block
CREATE TABLE comic(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    precio VARCHAR(255) NOT NULL,
    sinopsis TEXT NOT NULL,
    id_categoria INT NOT NULL,
    id_editorial INT NOT NULL,
    id_autor INT NOT NULL,
    id_existencia INT NOT NULL
);

--@block
CREATE TABLE categoria(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

--@block
CREATE TABLE editorial(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255)
);

--@block
CREATE TABLE autor(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255)
);

--@block
CREATE TABLE existencia(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT NOT NULL,
    cantidad INT,
    FOREIGN KEY(id_producto) REFERENCES comic(id)
);

--AGREGAR LAS LLAVES FORANEAS A LA TABLA COMIC
--@block
ALTER TABLE comic
ADD FOREIGN KEY(id_categoria) REFERENCES categoria(id); 

--@block
ALTER TABLE comic
ADD FOREIGN KEY(id_editorial) REFERENCES editorial(id);

--@block
ALTER TABLE comic
ADD FOREIGN KEY(id_autor) REFERENCES autor(id);

--@block
ALTER TABLE comic
ADD FOREIGN KEY(id_existencia) REFERENCES existencia(id);


--TABLA PRODUCTOSPEDIDOS
--@block
CREATE TABLE productosPedido(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_comic INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2),
    descuento DECIMAL(3, 2),
    FOREIGN KEY(id_pedido) REFERENCES pedido(id),
    FOREIGN KEY(id_comic) REFERENCES comic(id),
    CHECK(descuento <= 1)
);