<?php
    require 'includes/config/database.php';
    $db = conectarDB();
    session_start(); 
    
    $errores = [];
    $email = '';
    $password = '';
    $nombre = '';
    $apellido = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) ;
        $password = mysqli_real_escape_string( $db, $_POST['contraseña'] );
        $nombre = mysqli_real_escape_string( $db, $_POST['nombre']);
        $apellido = mysqli_real_escape_string( $db, $_POST['apellido'] );
        
        if(!$email){
            $errores[] = " El email es obligatorio o no es válido ";
        }

        if(!$password){
            $errores[] = " El password es obligatorio ";
        }
        if(!$nombre){
            $errores[] = " El nombre es obligatorio ";
        }

        if(!$apellido){
            $errores[] = " El apellido es obligatorio ";
        }


        if(empty($errores)){
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            //REVISAR SI EL USUARIO EXISTE
            $query = " INSERT INTO cliente (nombre, apellido, email, contraseña) VALUES ('${nombre}', '${apellido}', '${email}', '${passwordHash}')";
            $resultado = mysqli_query($db, $query);

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

                <label for="nombre">Nombre(s)</label>
                <input class="formulario__campo" type="text" id="nombre" name="nombre" placeholder="Nombre(s)" value="<?php echo $nombre; ?>" required> 

                <label for="apellido">Apellido(s)</label>
                <input class="formulario__campo" type="text" name="apellido" placeholder="Apellido(s)" value="<?php echo $apellido; ?>" required>

                <label for="email">E-mail</label>
                <input class="formulario__campo" type="email" id="email" name="email" placeholder="Tu correo" value="<?php echo $email; ?>" required> 

                <label for="contraseña">Contraseña</label>
                <input class="formulario__campo" type="password" name="contraseña" placeholder="Contraseña" <?php echo $password; ?>  required>

                <div class="alinear-derecha flex">
                    <input class="boton w-sm-100" type="submit" value="Registrarse">
                </div>
            </fieldset>
        </form>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>  