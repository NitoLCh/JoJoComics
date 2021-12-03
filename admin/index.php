<?php
    session_start();

    if($_SESSION['rol'] != 1){
        header('Location: /');
    }

    //IMPORTAR LA CONEXION
    require '../includes/config/database.php';
    $db = conectarDB();
    
    //ESCRIBIR EL QUERY
    $query = " SELECT comic.id as id, comic.nombre as nombre, comic.precio as precio, comic.imagen as imagen, comic.numPaginas as numPaginas, comic.año as año, comic.existencia as existencia, autor.nombre as autor, editorial.nombre as editorial, categoria.nombre as categoria FROM comic INNER JOIN autor ON autor.id = comic.id_autor INNER JOIN editorial ON editorial.id = comic.id_editorial INNER JOIN categoria ON categoria.id = comic.id_categoria ORDER BY nombre";

    //CONSULTAR LA BD
    $consulta = mysqli_query($db, $query);

    //MENSAJE CONDICIONAL
    $resultado = $_GET['resultado'] ?? null;

    //ELIMINAR PRODUCTO
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $eliminarArchivo = " SELECT imagen FROM comic WHERE id = ${id} ";
            
            $resultadoArch = mysqli_query($db, $eliminarArchivo);
            $comic = mysqli_fetch_assoc($resultadoArch);

            unlink('../portadas/' . $comic['imagen']);

            $eliminarRegistro = " DELETE FROM comic WHERE id = ${id} ";
            $resultadoElim = mysqli_query($db, $eliminarRegistro);

            if($resultadoElim){
                header('Location: /admin?resultado=3');
            }
        }
    }
    
    //INCLUYE UN TEMPLATE
    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <h1> ¡Hola <?php echo $_SESSION['nombre']; ?>!</h1>
        <h1>Administrador de Productos</h1>
        <?php if( intval( $resultado ) === 1 ): ?>
            <p class="alerta exito">Comic Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2 ): ?>
            <p class="alerta exito">Comic Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Comic Eliminado Correctamente</p>
        <?php endif; ?>
        <a class="boton" href="/admin/properties/crear.php" class=boton>Nuevo Comic</a>
        
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
                        <form method="POST" class="w-sm-100">
                            <input type="hidden" name="id" value="<?php echo $comic['id']; ?>">
                            <input type="submit" class="boton boton-rojo" value="Eliminar">
                        </form>
                        <a class="boton boton-amarillo" href="/admin/properties/actualizar.php?id=<?php echo $comic['id']; ?>">Actualizar</a>
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