<?php
    require 'app.php';

    function incluirTemplate(string $nombre, int $activo = 1){
        include TEMPLATES_URL. "/${nombre}.php";
    }