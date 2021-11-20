<?php 
    session_start();

    if($_SESSION['rol'] != 1){
        header('Location: /');
    }

    //VALIDACION DE LA URL POR EL ID
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    //BASE DE DATOS
    require'../../includes/config/database.php';
    $db = conectarDB();

    //CONSULTA PARA OBTENER LOS DATOS DEL COMIC
    $consultaDatos = " SELECT * FROM comic WHERE id = ${id} ";
    $resultadoDatos = mysqli_query( $db, $consultaDatos );
    $comic = mysqli_fetch_assoc( $resultadoDatos );
    
    //CONSULTA PARA OBTENER LAS EDITORIALES 
    $consultaEditorial = "SELECT * FROM editorial";
    $resultadoEditorial = mysqli_query($db, $consultaEditorial);
    //CONSULTA PARA OBTENER LOS AUTORES
    $consultaAutor = "SELECT * FROM autor";
    $resultadoAutor = mysqli_query($db, $consultaAutor);
    //CONSULTA PARA OBTENER LAS CATEGORÍAS
    $consultaCategoria = "SELECT * FROM categoria";
    $resultadoCategoria = mysqli_query($db, $consultaCategoria);

    
    //Arreglo con mensajes de errores
    $errores = [];

    $nombre = $comic['nombre'];
    $precio = $comic['precio'];
    $sinopsis = $comic['sinopsis'];
    $numPaginas = $comic['numPaginas'];
    $año = $comic['año'];
    $idCategoria  = $comic['id_categoria'];
    $idEditorial = $comic['id_editorial'];
    $idAutor = $comic['id_autor'];
    $existencia = $comic['existencia'];
    $imagenComic = $comic['imagen'];
   
    //Ejecutar el código después de que el usuario envía el formulario
    if($_SERVER['REQUEST_METHOD']==='POST'){

        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $sinopsis = mysqli_real_escape_string($db, $_POST['sinopsis']);
        $numPaginas = mysqli_real_escape_string($db, $_POST['numPaginas']);
        $año = mysqli_real_escape_string($db, $_POST['año']);
        $idCategoria  = mysqli_real_escape_string($db, $_POST['categoria']);
        $idEditorial = mysqli_real_escape_string($db, $_POST['editorial']);
        $idAutor = mysqli_real_escape_string($db, $_POST['autor']);
        $existencia = mysqli_real_escape_string($db, $_POST['existencia']);
        
        //ASIGNAR ARCHIVOS HACIA UNA VARIABLE
        $imagen = $_FILES['imagen'];

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
       
        //VALIDAR EL TAMAÑO DE LA IMAGEN
        $tamañoImagen = 1000 * 1000;

        //TAMAÑO MAXIMO = 1MB
        if($imagen['size'] > $tamañoImagen){
            $errores[] = "La imagen es muy pesada";
        }

        //REVISAR QUE EL ARREGLO DE ERRORES ESTÁ VACÍO
        if(empty($errores)){
            
            

            //CREAR CARPETA
            $carpetaImagenes = '../../portadas/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            /* SUBIDA DE ARCHIVOS */

            if( $imagen['name'] ){
                //ELIMINAR IMAGEN PREVIA
                unlink($carpetaImagenes . $comic['imagen']);
                
                //GENERAR UN NOMBRE UNICO A LA IMAGEN
                $nombreImagen = md5( uniqid( rand(), true )) . ".jpg";

                //SUBIR LA IMAGEN 
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            }
            else{
                $nombreImagen = $comic['imagen'];
            }

            

            //ACTUALIZAR COMIC
            $query = " UPDATE comic SET nombre = '${nombre}', precio = '${precio}', sinopsis = '${sinopsis}', numPaginas = '${numPaginas}', imagen = '${nombreImagen}', año = '${año}', id_categoria = ${idCategoria}, id_editorial = ${idEditorial}, id_autor = ${idAutor}, existencia = ${existencia} WHERE id = ${id} "; 
          
            $insercion = mysqli_query($db, $query);

            if($insercion){
                //REDIRECCIONAR AL USUARIO
                header('Location: /admin?resultado=2');
            }

        }
    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <h1>Actualizar Comic</h1>
        <a href="/admin" class=boton>Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" id="crear-comic" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="nombre">Titulo</label>
                <input class="formulario__campo" type="text" id="nombre" name="nombre" placeholder="Titulo Comic" value="<?php echo $nombre; ?>">
                
                <label for="precio">Precio</label>
                <input class="formulario__campo" type="number" required min="1" step="any" id="precio" name="precio" value="<?php echo $precio; ?>">
                
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
                <input class="formulario__campo formulario__campo--imagen" type="file" id="imagen" name="imagen" accept="image/png, image/jpg, image/jpeg">
                
                <img src="/portadas/<?php echo $imagenComic ?>" class="imagen-small">
            
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
        <button class="boton" type="submit" form="crear-comic">Actualizar Comic</button>
    </main>
<?php
    incluirTemplate('footer');
?>