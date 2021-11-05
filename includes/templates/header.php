<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoJoComics - Tu Tienda Nerd Favorita</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap" 
    rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/Logo_nuevo.png" alt="logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace <?php echo $activo===1 ? 'navegacion__enlace--activo' : ''; ?>" href="index.php">Tienda</a>
        <a class="navegacion__enlace <?php echo $activo===2 ? 'navegacion__enlace--activo' : ''; ?>" href="nosotros.php">Nosotros</a>
        <a class="navegacion__enlace <?php echo $activo===3 ? 'navegacion__enlace--activo' : ''; ?>" href="contactanos.php">Contactanos</a>
    </nav>