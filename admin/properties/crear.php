<?php 
    //BASE DE DATOS
    require'../../includes/config/database.php';
    $db = conectarDB();
    //Arreglo con mensajes de errores
    $errores = [];

    $nombre = '';
    $precio = '';
    $sinopsis = '';
    $numPaginas = '';
    $año = '';
    $idCategoria  = '';
    $idEditorial = '';
    $idAutor = '';
    $existencia = '';
   

    //CONSULTAR PARA OBTENER LAS EDITORIALES 
    $consultaEditorial = "SELECT * FROM editorial";
    $resultadoEditorial = mysqli_query($db, $consultaEditorial);
    $consultaAutor = "SELECT * FROM autor";
    $resultadoAutor = mysqli_query($db, $consultaAutor);
    $consultaCategoria = "SELECT * FROM categoria";
    $resultadoCategoria = mysqli_query($db, $consultaCategoria);

    //Ejecutar el código después de que el usuario envía el formulario
    if($_SERVER['REQUEST_METHOD']==='POST'){

        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $sinopsis = $_POST['sinopsis'];
        $numPaginas = $_POST['numPaginas'];
        $año = $_POST['año'];
        $idCategoria  = $_POST['categoria'];
        $idEditorial = $_POST['editorial'];
        $idAutor = $_POST['autor'];
        $existencia = $_POST['existencia'];
        

        if(!$nombre){
            $errores[]= "Debes añadir un título";
        }
        if(!$precio){
            $errores[]= "Debes añadir el precio";
        }
        if(strlen($sinopsis) < 50){
            $errores[]= "La sinopsis debe tener al menos 50 caracteres";
        }
        if(!$numPaginas){
            $errores[]= "Debes añadir el número de páginas";
        }
        if(!$año){
            $errores[]= "Debes añadir el año";
        }
        if(!$idCategoria){
            $errores[]= "Debes añadir una categoría";
        }
         if(!$idEditorial){
            $errores[]= "Debes añadir una editorial";
        }
        if(!$idAutor){
            $errores[]= "Debes añadir al autor";
        }
        if(!$existencia){
            $errores[]= "Debes añadir la existencia";
        }
        

        //REVISAR QUE EL ARREGLO DE ERRORES ESTÁ VACÍO
        if(empty($errores)){
            //INSERTAR EN LA BASE DE DATOS
            $query = " INSERT INTO comic (nombre, precio, sinopsis, numPaginas, año, id_categoria, id_editorial, id_autor, existencia) VALUES ( '$nombre', '$precio', '$sinopsis', '$numPaginas', '$año', '$idCategoria', '$idEditorial', '$idAutor', '$existencia' ) ";

            $insercion = mysqli_query($db, $query);

            echo $query;

            if($insercion){
                //REDIRECCIONAR AL USUARIO
                header('Location: /admin');
            }

        }
    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <h1>Crear</h1>
        <a href="/admin" class=boton>Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" id="crear-comic" method="POST" action="/admin/properties/crear.php">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="nombre">Titulo</label>
                <input class="formulario__campo" type="text" id="nombre" name="nombre" placeholder="Titulo Comic" value="<?php echo $nombre; ?>">
                <label for="precio">Precio</label>
                <input class="formulario__campo" type="number" min="1" id="precio" name="precio" value="<?php echo $precio; ?>">
                <label for="Autor">Autor</label>
                <select class="formulario__campo" id="autor" name="autor">
                    <option disabled selected>--Autor--</option>
                    <?php while($autor = mysqli_fetch_assoc($resultadoAutor)): ?>
                        <option <?php echo $idAutor == $autor['id'] ? 'selected' : ''; ?> value="<?php echo $autor['id']; ?>">
                        <?php echo $autor['nombre'];?>
                        </option>
                    <?php endwhile; ?>
                </select> 
                <label for="año">Año</label>
                <input class="formulario__campo" type="number" id="año" min="1900" name="año" max="2099" value="<?php echo $año; ?>">
                <label for="numPaginas">Paginas</label>
                <input class="formulario__campo" type="text" id="numPaginas" name="numPaginas" placeholder="N° de Páginas" value="<?php echo $numPaginas; ?>">
                <label for="imagen">Imagen</label>
                <input class="formulario__campo formulario__campo--imagen" type="file" id="imagen" accept="image/png, image/jpg, image/jpeg">
            </fieldset>

            <fieldset>
                <legend>Detalles</legend>
                <label for="categoria">Categoría</label>
                <select class="formulario__campo" name="categoria" id="categoria">
                    <option disabled selected>--Categoría--</option>
                    <?php while($categoria = mysqli_fetch_assoc($resultadoCategoria)): ?>
                        <option <?php echo $idCategoria == $categoria['id'] ? 'selected' : ''; ?> value="<?php echo $categoria['id']; ?>">
                        <?php echo $categoria['nombre'];?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label for="editorial">Editorial</label>
                <select class="formulario__campo" type="text" id="editorial" name="editorial">
                    <option disabled selected>--Editorial--</option>
                    <?php while($editorial = mysqli_fetch_assoc($resultadoEditorial)): ?>
                        <option <?php echo $idEditorial == $editorial['id'] ? 'selected' : ''; ?> value="<?php echo $editorial['id'] ?>">
                        <?php echo $editorial['nombre'];?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label for="existencia">Existencia</label>
                <input class="formulario__campo" type="number" min="0" id="existencia" name="existencia" value="<?php echo $existencia; ?>">
                <label for="sinopsis">Sinopsis</label>
                <textarea class="formulario__campo--textarea" id="sinopsis" name="sinopsis"> <?php echo $sinopsis; ?> </textarea>
            </fieldset> 
        </form>
        <button class="boton" type="submit" form="crear-comic">Crear Comic</button>
    </main>
<?php
    incluirTemplate('footer');
?>