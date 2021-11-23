<?php
    session_start();

    //IMPORTAR LA CONEXION
    require 'includes/config/database.php';
    $db = conectarDB();
    $id_cliente = $_SESSION['id'];

    if($_SESSION['id']){
        $query = " SELECT carrito.id_cliente as id_cliente, carritoProducto.id_carrito as id_carrito, comic.imagen as imagen, comic.nombre as titulo, autor.nombre as autor, comic.precio as precio, carritoProducto.cantidad as cantidad FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic INNER JOIN autor ON autor.id = comic.id_autor WHERE carrito.id_cliente = $id_cliente ";

        $resultado = mysqli_query($db, $query);

        $consultaTotal = " SELECT SUM(comic.precio * carritoProducto.cantidad) as subtotal FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic WHERE id_cliente = $id_cliente ";
        
        $resultadoSuma = mysqli_query($db, $consultaTotal);
        $suma = mysqli_fetch_assoc($resultadoSuma);
        $subtotal = $suma['subtotal']; 
    }
    //INCLUYE UN TEMPLATE
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <?php if($_SESSION['nombre']): ?>
        <h1> ¡Hola <?php echo $_SESSION['nombre']; ?>!</h1>
        <h1>Tu carrito de compras</h1>
        <?php endif; ?>
        <?php if(!$_SESSION['nombre']): ?>
            <h1>No has iniciado sesión</h1>
            <a href="/login.php"><h1>Logueate aquí</h1></a>
            <h1>O</h1> <a href="/registro.php"><h1>Registrate aquí</h1></a>
        <?php endif; ?>
        <div class="carrito">
            <?php while( $producto = mysqli_fetch_assoc($resultado) ): ?>
            <div class="carrito__producto">
                <a href="#">
                    <img src="/portadas/<?php echo $producto['imagen']; ?>" class="carrito__imagen">
                </a>
                <div class="carrito__info">
                    <a href="#">
                        <p class="carrito__info--titulo"><?php echo $producto['titulo']; ?></p>
                    </a>
                    <p class="carrito__info--autor">por <?php echo $producto['autor']; ?></p>
                    <p class="carrito__info--precio">$ <?php echo $producto['precio']; ?></p>
                    <a class="carrito__info--UD">Cantidad: <?php echo $producto['cantidad']; ?></a>
                    <a class="carrito__info--UD" href="">Eliminar</a>
                </div>
            </div>
            <?php endwhile; ?>
            <div >
                <h3 class="carrito__subtotal">Subtotal: $<?php echo $subtotal; ?></h3>
                <button class="boton">Proceder al Pago</button>
            </div>
    </main>

<?php

    //CERRAR LA CONEXIÓN
    mysqli_close($db);

    incluirTemplate('footer');
?>