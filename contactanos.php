<?php 
   session_start();
   require 'includes/funciones.php';
   incluirTemplate('header', 3);
?>

    <main class="contenedor">
        <h1>¿No encuentras lo que buscas?</h1>
        <h2>Dejanos tu sugerencia 😃</h2>
        <form class="formulario" id="formulario">
            <fieldset>
                <legend>Haz tu pedido</legend>
                <input class="formulario__campo" type="text" name="nombre" placeholder="Tu nombre" id="nombre">
                <input class="formulario__campo" type="text" name="correo" placeholder="Tu correo" id="correo"> 
                <input class="formulario__campo" type="text" name="comic" placeholder="Nombre del Comic" id="comic">
                <input class="formulario__campo" type="text" name="editorial" placeholder="Editorial" id="editorial"> 
                <input class="formulario__campo" type="number" min="1900" max="2099" step="1" name="año" placeholder="Año de publicación" id="año">
                <div class="alinear-derecha flex">
                    <input class="boton w-sm-100" type="submit" value="Enviar petición">
                </div>
            </fieldset>
        </form>
    </main>

    <script src="scripts/contactanos.js"></script>

    <?php 
        incluirTemplate('footer');
    ?>