<?php
    function conectarDB() : mysqli{
        $db = mysqli_connect('b8uxlnucrai5wm4jiap9-mysql.services.clever-cloud.com', 'uupvmapcw7xdacfk', 'gQuxE2Ug9klrbebD0dmr', 'b8uxlnucrai5wm4jiap9');
        $db->set_charset('utf8');
        if(!$db){
            echo "No se ha podido conectar a la base de datos";
            exit;
        }
        return $db;
    }
?>