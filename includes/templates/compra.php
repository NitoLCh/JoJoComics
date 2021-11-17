<?php
     $id = $_GET['id'];
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
?>

<main class="contenedor">
    <h1><?php echo $comic['nombre']; ?></h1>
    <div class="tienda">
        <img class="tienda__imagen" src="../../portadas/<?php echo $comic['imagen']; ?>" alt="Producto">
        <div>
            <p>
                <?php echo $comic['sinopsis']; ?>
            </p>

            <form class="formulario">   
                <input class="formulario__campo" type="number" placeholder="Cantidad" min="1">
            </form>
            <input class="boton w-sm-100" type="submit" value="Agregar al Carrito">
        </div>
    </div>
</main>

<?php 
//CERRAR LA CONEXIÓN
mysqli_close($db);

?>