<?php
    //IMPORTAR LA CONEXION A LA BD
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();
  

    //CONSULTAR 
    $query = " SELECT comic.id as id, comic.nombre as nombre, comic.precio as precio, comic.imagen as imagen, comic.numPaginas as numPaginas, comic.año as año, comic.existencia as existencia, autor.nombre as autor, editorial.nombre as editorial, categoria.nombre as categoria FROM comic INNER JOIN autor ON autor.id = comic.id_autor INNER JOIN editorial ON editorial.id = comic.id_editorial INNER JOIN categoria ON categoria.id = comic.id_categoria ORDER BY id";

    //LEER LOS RESULTADOS
    $resultado = mysqli_query($db, $query);
?>

<div class="grid">
    <?php while( $comic = mysqli_fetch_assoc($resultado) ): ?>
    <div class="producto">
        <a href="/tienda.php?id=<?php echo $comic['id']; ?>">
            <img class="producto__portada" src="../../portadas/<?php echo $comic['imagen']; ?>" alt="imagen comic">
            <div class="producto__informacion">
                <p class="producto__titulo"> <?php echo $comic['nombre']; ?> </p>
                <p class="producto__precio"> <?php echo '$' . $comic['precio']; ?> </p>
                <p class="producto__info"><?php echo $comic['autor']; ?> </p>
                <p class="producto__info"><?php echo $comic['año']; ?> </p>
                <p class="producto__info"><?php echo $comic['numPaginas'] . ' páginas'; ?> </p>
            </div> 
        </a>
    </div>
    <?php endwhile; ?>
</div>

<?php 
//CERRAR LA CONEXIÓN
mysqli_close($db);

?>