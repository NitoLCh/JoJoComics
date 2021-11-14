<?php 
    //IMPORTAR LA CONEXION
    require '../includes/config/database.php';
    $db = conectarDB();
    
    //ESCRIBIR EL QUERY
    $query = " SELECT comic.id as id, comic.nombre as nombre, comic.precio as precio, comic.imagen as imagen, comic.numPaginas as numPaginas, comic.año as año, comic.existencia as existencia, autor.nombre as autor, editorial.nombre as editorial, categoria.nombre as categoria FROM comic INNER JOIN autor ON autor.id = comic.id_autor INNER JOIN editorial ON editorial.id = comic.id_editorial INNER JOIN categoria ON categoria.id = comic.id_categoria ORDER BY nombre";

    //CONSULTAR LA BD
    $consulta = mysqli_query($db, $query);

    //MENSAJE CONDICIONAL
    $resultado = $_GET['resultado'] ?? null;
    
    //INCLUYE UN TEMPLATE
    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <h1>Administrador de Productos</h1>
        <?php if( intval( $resultado ) === 1 ): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php endif; ?>
        <a class="boton" href="/admin/properties/crear.php" class=boton>Nueva propiedad</a>
        
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>N°Paginas</th>
                    <th>Año</th>
                    <th>Existencias</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody><!-- MOSTRAR LOS RESULTADOS -->
                <?php while($comic = mysqli_fetch_assoc($consulta)): ?>
                <tr>
                    <td> <?php echo $comic['id']; ?> </td>
                    <td> <?php echo $comic['nombre']; ?> </td>
                    <td> <?php echo $comic['precio']; ?> </td>
                    <td><img src="../portadas/<?php echo $comic['imagen'];?>" class="imagen-tabla"></td>
                    <td> <?php echo $comic['numPaginas']; ?> </td>
                    <td> <?php echo $comic['año']; ?> </td>
                    <td> <?php echo $comic['existencia']; ?> </td>
                    <td> <?php echo $comic['autor']; ?> </td>
                    <td> <?php echo $comic['editorial']; ?> </td>
                    <td> <?php echo $comic['categoria']; ?> </td>
                    <td>
                        <a class="boton boton-rojo" href="#">Eliminar</a>
                        <a class="boton boton-amarillo" href="#">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php

    //CERRAR LA CONEXIÓN
    mysqli_close($db);

    incluirTemplate('footer');
?>