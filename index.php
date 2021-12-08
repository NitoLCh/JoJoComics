<?php 
    session_start();
    
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor">
        <h1>Nuestros Comics</h1>
        <?php incluirTemplate('comics'); ?>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>