<?php
    require 'includes/config/database.php';
    $db = conectarDB();
    session_start(); 
    
    $errores = [];
    $email = '';
    $password = '';
    $nombreUsuario = '';
    $nombre = '';
    $apellido = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) ;
        $password = mysqli_real_escape_string( $db, $_POST['contraseña'] );
        $nombreUsuario = mysqli_real_escape_string( $db, $_POST['nombreUsuario']);
        $nombre = mysqli_real_escape_string( $db, $_POST['nombre']);
        $apellido = mysqli_real_escape_string( $db, $_POST['apellido'] );
        
        if(!$email){
            $errores[] = " El email es obligatorio o no es válido ";
        }

        if(!$password){
            $errores[] = " El password es obligatorio ";
        }

        if(!$nombreUsuario){
            $errores[] = " El nombre de usuario es obligatorio ";
        }

        if(!$nombre){
            $errores[] = " El nombre es obligatorio ";
        }

        if(!$apellido){
            $errores[] = " El apellido es obligatorio ";
        }

        $queryVerificacion = " SELECT id FROM cliente WHERE email = $email ";
        $verificacion = mysqli_query($db, $queryVerificacion);
        var_dump($queryVerificacion);
        if($verificacion){
            $errores[] = " El email ya existe ";
        }
        $queryVerificacionUser = " SELECT id FROM cliente WHERE nombreUsuario = $nombreUsuario ";
        $verificacionUser = mysqli_query($db, $queryVerificacionUser);
        if(!$nombreUsuario){
            $errores[] = " El nombre de usuario ya existe ";
        }

        if(empty($errores)){
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            //INSERTAR
            $query = " INSERT INTO cliente (nombreUsuario, nombre, apellido, email, contraseña) VALUES ('${nombreUsuario}','${nombre}', '${apellido}', '${email}', '${passwordHash}')";
            $resultado = mysqli_query($db, $query);

            $queryID = " SELECT id FROM cliente WHERE email = '${email}' ";
            $resultadoId = mysqli_query($db, $queryID);

            $cliente = mysqli_fetch_assoc($resultadoId);
            $clienteid = $cliente['id'];

            $queryCarro = " INSERT INTO carrito (id_cliente) VALUES ($clienteid) ";
            $insercionCarrito = mysqli_query($db, $queryCarro);

            header('Location: /login.php');
        }
    } 

    if($_SESSION){
        header('Location: /');
    }

    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor">
        <h1>Registro</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" id="login" method="POST">
            <fieldset>
                <legend>Registrate</legend>
                <label for="apellido">Nombre de Usuario</label>
                <input class="formulario__campo" type="text" name="nombreUsuario" placeholder="Nombre De Usuario" value="<?php echo $nombreUsuario; ?>" required>

                <label for="email">E-mail</label>
                <input class="formulario__campo" type="email" id="email" name="email" placeholder="Tu correo" value="<?php echo $email; ?>" required> 

                <label for="contraseña">Contraseña</label>
                <input class="formulario__campo" type="password" name="contraseña" placeholder="Contraseña" <?php echo $password; ?>  required>

                <label for="nombre">Nombre(s)</label>
                <input class="formulario__campo" type="text" id="nombre" name="nombre" placeholder="Nombre(s)" value="<?php echo $nombre; ?>" required> 

                <label for="apellido">Apellido(s)</label>
                <input class="formulario__campo" type="text" name="apellido" placeholder="Apellido(s)" value="<?php echo $apellido; ?>" required>

                <div class="alinear-derecha flex">
                    <input class="boton w-sm-100" type="submit" value="Registrarse">
                </div>
            </fieldset>
        </form>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>  