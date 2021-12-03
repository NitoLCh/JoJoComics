<?php
     $id = $_GET['id'];
     $request = $_GET['request'];
     $id = filter_var($id, FILTER_VALIDATE_INT);
 
     if(!$id){
         header('Location: /');
     } 
    //IMPORTAR LA CONEXION A LA BD
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();
    
    //CONSULTAR 
    $query = " SELECT comic.id as id, comic.nombre as nombre, comic.imagen as imagen, comic.sinopsis as sinopsis, editorial.nombre as editorial FROM comic INNER JOIN editorial ON editorial.id = comic.id_editorial AND comic.id = ${id} ";

    //LEER LOS RESULTADOS
    $resultado = mysqli_query($db, $query);
    $comic = mysqli_fetch_assoc($resultado);

    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
        $id_comic = $_POST['id_producto'];
        $id_cliente = $_SESSION['id'];
        $consulta_carrito = " SELECT id FROM carrito WHERE id_cliente = $id_cliente ";
        $resultado_consulta_carrito = mysqli_query($db, $consulta_carrito);
        $carrito = mysqli_fetch_assoc($resultado_consulta_carrito);
        $id_carrito = $carrito['id'];
        $cantidad = mysqli_real_escape_string( $db, $_POST['cantidad'] );

        $queryVerificacion = " SELECT id_carrito, id_comic FROM carritoProducto WHERE id_carrito = '${id_carrito}' AND id_comic = '${id_comic}'";
        $resultaVerificacion = mysqli_query($db, $queryVerificacion);
        $verificacion = mysqli_fetch_assoc($resultaVerificacion);
        
        if($verificacion===NULL){
            $query = " INSERT INTO carritoProducto(id_carrito, id_comic, cantidad) VALUES ('${id_carrito}', '${id_comic}', '${cantidad}')";
            $resultado = mysqli_query($db, $query);

            if($resultado){
                header("Location: /tienda.php?id=$id&request=1");
            }
        }
        if($verificacion['id_carrito']){
            $query = " UPDATE carritoProducto SET cantidad = cantidad + ${cantidad} WHERE id_carrito = '${id_carrito}' AND id_comic = '${id_comic}'";
            $resultado = mysqli_query($db, $query);

            if($resultado){
                header("Location: /tienda.php?id=$id&request=1");
            }
        }
    }
?>

<main class="contenedor">
    <?php if( intval( $request ) === 1 ): ?>
        <p class="alerta exito">Comic Agragado al Carrito Exitosamente</p>
    <?php endif; ?>
    <h1><?php echo $comic['nombre']; ?></h1>
    <div class="tienda">
        <img class="tienda__imagen" src="../../portadas/<?php echo $comic['imagen']; ?>" alt="Producto">
        <div class="tienda__info">
            <p>
                <?php echo $comic['sinopsis']; ?>
            </p>

            <form id="compra" class="formulario" method="POST">   
                <input type="hidden" name="id_producto" value="<?php echo $comic['id'];?>">
                <input class="formulario__campo" type="number" name="cantidad" placeholder="Cantidad" min="1" value="1">
            </form>
            <input class="boton w-sm-100" type="submit" form="compra" value="Agregar al Carrito">
        </div>
    </div>
</main>

<?php 
//CERRAR LA CONEXIÓN
mysqli_close($db);

?>