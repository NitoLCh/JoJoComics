<?php
     session_start();

     //IMPORTAR LA CONEXION
     require __DIR__ . '/../config/database.php';
     $db = conectarDB();
     $id_cliente = $_SESSION['id'];
    
     //CONSULTAS PARA MOSTRAR EN PANTALLA
     if($_SESSION['id'])
     {
         $query = " SELECT carrito.id_cliente as id_cliente, carritoProducto.id_carrito as id_carrito, carritoProducto.id_comic as id_comic, comic.nombre as titulo, comic.precio as precio, carritoProducto.cantidad as cantidad, (comic.precio * carritoProducto.cantidad) as total FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic INNER JOIN autor ON autor.id = comic.id_autor WHERE carrito.id_cliente = $id_cliente ";
 
         $resultado = mysqli_query($db, $query);
 
        /*CONSULTA DEL TOTAL DE LOS PRODUCTOS*/
        $consultaTotal = " SELECT SUM(comic.precio * carritoProducto.cantidad) as subtotal, COUNT(carritoProducto.id) as cuentaProuctos FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic WHERE id_cliente = $id_cliente ";
            
        $resultadoSuma = mysqli_query($db, $consultaTotal);
        $suma = mysqli_fetch_assoc($resultadoSuma);
        $total = $suma['subtotal'] + ($suma['subtotal'] * 0.16);
        $total = round($total, 2); 
        $cuentaProductos = $suma['cuentaProuctos']-1; 
     }
 ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura</title>
</head>
<body>
    <h1 align="center">Factura de Orden de Compra</h1>
    <table width=80% border="1px solid black" align="center">
        <thead align="center">
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>


        <tbody>
            <?php while($compra = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo $compra['titulo']?></td>
                <td><?php echo $compra['cantidad']?></td>
                <td><?php echo $compra['precio']?></td>
                <td><?php echo $compra['total']?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h3 align="right">Total(+IVA): $<?php echo $total ?></h3>
    <a href="/" onclick="this.parentNode.submit()">Regresar al inicio</a>
    
</body>
</html>