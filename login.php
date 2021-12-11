<?php
    require 'includes/config/database.php';
    $db = conectarDB();
    session_start();
    
    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) ;
        $password = mysqli_real_escape_string( $db, $_POST['contraseña'] );
        
        if(!$email){
            $errores[] = " El email es obligatorio o no es válido ";
        }

        if(!$password){
            $errores[] = " El password es obligatorio ";
        }

        if(empty($errores)){
            
            //REVISAR SI EL USUARIO EXISTE
            $query = " SELECT * FROM cliente WHERE email = '${email}' ";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                //REVISAR SI EL PASSWORD ES CORRECTO
                $usuario = mysqli_fetch_assoc($resultado);

                //REVISAR SI EL PASSWORD ES CORRECTO O NO
                $auth = password_verify($password, $usuario['contraseña']);

                if($auth){
                    //El usuario está autenticado
                    session_start();
                    $_SESSION['correo'] = $usuario['email'];
                    $_SESSION['rol'] = $usuario['administrador'];
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $usuario['nombreUsuario'];
                    header('Location: /');

                }
                else{
                    $errores[] = "El password es incorrecto";
                }
            }
            else{
                $errores[] = " El Usuario no existe "; 
            }

        }
    } 

    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" id="login" method="POST">
            <fieldset>
                <legend>Email y Constraseña</legend>

                <label for="email">E-mail</label>
                <input class="formulario__campo" type="email" id="email" name="email" placeholder="Tu correo" > 

                <label for="contraseña">Contraseña</label>
                <input class="formulario__campo" type="password" id="contraseña" name="contraseña" placeholder="Contraseña" >

                <a class="link" href="/registro.php">¿No tienes una cuenta? Registrate</a>

                <div class="alinear-derecha flex">
                    <input class="boton w-sm-100" type="submit" value="Iniciar Sesión">
                </div>
            </fieldset>
        </form>
    </main>

    <script src="scripts/login.js"></script>

    <?php 
        incluirTemplate('footer');
    ?>  