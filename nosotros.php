<?php 
   session_start();
   require 'includes/funciones.php';
   incluirTemplate('header', 2);
?>
    
    <main class="contenedor">
        <h1>Nosotros</h1>

        <div class="nosotros">
            <div class="nosotros__contenido">
                <p>
                    Proyecto: Tienda virtual con Css <br><br><br><br>
                </p>
                
                <p>
                    Jorge Alejandro Ledesma Chavez<br><br>
                    19130930 <br><br>
                    Jose Eduardo Espino Ramirez <br><br>
                    19130905
                </p>
            </div>
            <img class="nosotros__imagen" src="img/nosotros.jpg" alt="imagen nosotros">
        </div>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>