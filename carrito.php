<?php
    session_start();

    //IMPORTAR LA CONEXION
    require 'includes/config/database.php';
    $db = conectarDB();
    

    
    //INCLUYE UN TEMPLATE
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <?php if($_SESSION['nombre']): ?>
        <h1> ¡Hola <?php echo $_SESSION['nombre']; ?>!</h1>
        <h1>Tu carrito de compras</h1>
        <?php endif; ?>
        <?php if(!$_SESSION['nombre']): ?>
            <h1>No has iniciado sesión</h1>
            <a href="/login.php"><h1>Logueate aquí</h1></a>
            <h1>O</h1> <a href="/registro.php"><h1>Registrate aquí</h1></a>
        <?php endif; ?>
        
    </main>

<?php

    //CERRAR LA CONEXIÓN
    mysqli_close($db);

    incluirTemplate('footer');
?>