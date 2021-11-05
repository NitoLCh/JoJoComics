<?php 
    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor">
        <h1>Crear</h1>
        <a href="/admin" class=boton>Volver</a>

        <form>
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="precio" placeholder="Titulo Comic">

                <label for="Precio"></label>

            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>