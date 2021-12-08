<?php
    session_start();

    //IMPORTAR LA CONEXION
    require 'includes/config/database.php';
    $db = conectarDB();
    $id_cliente = $_SESSION['id'];

    //CONSULTAS PARA MOSTRAR EN PANTALLA
    if($_SESSION['id']){
        $query = " SELECT carrito.id_cliente as id_cliente, carritoProducto.id_carrito as id_carrito, carritoProducto.id_comic as id_comic, comic.imagen as imagen, comic.nombre as titulo, autor.nombre as autor, comic.precio as precio, carritoProducto.cantidad as cantidad FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic INNER JOIN autor ON autor.id = comic.id_autor WHERE carrito.id_cliente = $id_cliente ";

        $resultado = mysqli_query($db, $query);

        $consultaTotal = " SELECT SUM(comic.precio * carritoProducto.cantidad) as subtotal FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic WHERE id_cliente = $id_cliente ";
        
        $resultadoSuma = mysqli_query($db, $consultaTotal);
        $suma = mysqli_fetch_assoc($resultadoSuma);
        $subtotal = $suma['subtotal']; 
    }

    //ELIMINAR PRODUCTO
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
        
        $id_comic = $_POST['id_comic'];
        $id_comic = filter_var($id_comic, FILTER_VALIDATE_INT);
        $id_carrito = $_POST['id_carrito'];
        $id_carrito = filter_var($id_carrito, FILTER_VALIDATE_INT);

        if($id_comic){
            $eliminarProducto = " DELETE FROM carritoProducto WHERE id_comic = ${id_comic} AND id_carrito = ${id_carrito} ";
            $resultadoElim = mysqli_query($db, $eliminarProducto);
        }
        if($resultadoElim){
            header('Location: /carrito.php');
        }
    }

    //INCLUYE UN TEMPLATE
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">

        <?php if($_SESSION['nombre']): ?>
        <h1> ¡Hola <?php echo $_SESSION['nombre']; ?>!</h1>
        <?php endif; ?>
        
        <?php if(!$_SESSION['nombre']): ?>
            <h3>No has iniciado sesión</h3>
            <a href="/login.php"><h1>Logueate aquí</h1></a>
            <h1>O</h1> <a href="/registro.php"><h1>Registrate aquí</h1></a>
        <?php endif; ?>
        
        <?php if($subtotal): ?>
            <div class="carrito">
                <?php while( $producto = mysqli_fetch_assoc($resultado) ): 
                    $id_carrito = $producto['id_carrito'];?>
                <div class="carrito__producto">
                    
                    <a href="#">
                        <img class="carrito__imagen" src="/portadas/<?php echo $producto['imagen']; ?>" >
                    </a>

                    <div class="carrito__info">
                        <a href="#">
                            <p class="carrito__info--titulo"><?php echo $producto['titulo']; ?></p>
                        </a>
                        <p class="carrito__info--autor">por <?php echo $producto['autor']; ?></p>
                        <p class="carrito__info--precio">$ <?php echo $producto['precio']; ?></p>
                        <a class="carrito__info--UD">Cantidad: <?php echo $producto['cantidad']; ?></a>

                        <form method="POST">
                            <input type="hidden" name="id_comic" value="<?php echo $producto['id_comic']; ?>">
                            <input type="hidden" name="id_carrito" value="<?php echo $producto['id_carrito']; ?>">
                            <input type="submit" value="Eliminar" class="reset carrito__info--UD"></input>
                        </form>

                    </div>
                </div>
                <?php endwhile; ?>

                <div class="carrito__total">
                    <h2 class="carrito__subtotal">Subtotal: $<?php echo $subtotal; ?> MXN</h2>
                    <a href="/check-out.php?id=<?php echo $id_carrito; ?>" class="boton">Proceder al Pago</a>
                </div>
                        
            </div>
            <?php endif; ?>

            <?php if(!$subtotal): ?>
                <h1 class="carrito__vacio">No Has Agregado nada al Carrito</h1>
            <?php endif; ?>
    </main>

<?php

    //CERRAR LA CONEXIÓN
    mysqli_close($db);

    incluirTemplate('footer');
?>