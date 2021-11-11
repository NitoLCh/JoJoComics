<?php 
   require 'includes/funciones.php';
   incluirTemplate('header', 3);
?>
    <main>
        <h1>¿No encuentras lo que buscas?</h1>
        <h2>Dejanos tu sugerencia 😃</h2>
        <form class="formulario">
            <fieldset>
                <legend>Haz tu pedido</legend>
                <input class="formulario__campo" type="text" name="nombre" placeholder="Tu nombre" size="35"> <br><br>
                <input class="formulario__campo" type="email" name="correo" placeholder="Tu correo" size="35"> <br><br>
                <input class="formulario__campo" type="text" name="comic" placeholder="Nombre del Comic" size="35"> <br><br>
                <input class="formulario__campo" type="text" name="editorial" placeholder="Editorial" size="35"> <br><br>
                <input class="formulario__campo" type="number" min="1900" max="2099" step="1" name="año" placeholder="Año de publicación" size="35">
                <div class="alinear-derecha flex">
                    <input class="boton w-sm-100" type="submit" value="Enviar petición">
                </div>
            </fieldset>
        </form>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>