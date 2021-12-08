<?php 
    session_start();
    require 'includes/config/database.php';
    
    $db = conectarDB();
    $id_cliente = $_SESSION['id'];

    //CONSULTAS PARA MOSTRAR EN PANTALLA
    if($_SESSION['id']){
        /*CONSULTA DE SELECCION DE PRODUCTOS*/
        $query = " SELECT carrito.id_cliente as id_cliente, carritoProducto.id_carrito as id_carrito, carritoProducto.id_comic as id_comic, comic.imagen as imagen, comic.nombre as titulo, autor.nombre as autor, comic.precio as precio, carritoProducto.cantidad as cantidad FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic INNER JOIN autor ON autor.id = comic.id_autor WHERE carrito.id_cliente = $id_cliente ";

        $resultado = mysqli_query($db, $query);
        $compra = mysqli_fetch_assoc($resultado);

        /*CONSULTA DEL TOTAL DE LOS PRODUCTOS*/
        $consultaTotal = " SELECT SUM(comic.precio * carritoProducto.cantidad) as subtotal, COUNT(carritoProducto.id) as cuentaProuctos FROM carritoProducto INNER JOIN carrito ON  carrito.id = carritoProducto.id_carrito INNER JOIN comic ON comic.id = carritoProducto.id_comic WHERE id_cliente = $id_cliente ";
        
        $resultadoSuma = mysqli_query($db, $consultaTotal);
        $suma = mysqli_fetch_assoc($resultadoSuma);
        $total = $suma['subtotal'] + ($suma['subtotal'] * 0.16);
        $total = round($total, 2); 
        $cuentaProductos = $suma['cuentaProuctos']-1;
    }

   /* var_dump($_POST);
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
        $id_carrito = $_POST['id_carrrito'];
        $id_carrito = filter_var($id_carrito, FILTER_VALIDATE_INT);

        if($id_carrito){
            $eliminarCarrito = " DELETE FROM carritoProducto WHERE id_carrito = ${id_carrito} ";
            $resultadoElim = mysqli_query($db, $eliminarCarrito);
            if($resultadoElim){
                header('Location: /index.php');
            }
        }
    }*/

    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor">
    <h1>Paga tu producto aquí</h1>
    <div class="carrito">
        <div class="carrito__producto">
            
            <a href="#">
                <img class="carrito__imagen" src="/portadas/<?php echo $compra['imagen']; ?>" >
            </a>

            <div class="carrito__info--compra">
                <a href="#">
                    <p class="carrito__info--titulo"><?php echo $compra['titulo']; ?></p>
                    <?php if($cuentaProductos > 1): ?>
                    <p class="carrito__info--titulo">y otros <?php echo $cuentaProductos; ?> articulos</p>
                    <?php endif; ?>
                    <?php if($cuentaProductos === 1): ?>
                    <p class="carrito__info--titulo">y otro artículo</p>
                    <?php endif; ?>
                </a>
            </div>

        </div>
        <div class="carrito__total">
            <h3 class="carrito__subtotal">Total: $<?php echo $total; ?> MXN</h3>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=MXN" data-sdk-integration-source="button-factory"></script>
            <script>
                function initPayPalButton() {
                paypal.Buttons({
                    style: {
                    shape: 'pill',
                    color: 'blue',
                    layout: 'horizontal',
                    label: 'pay',
                    
                    },

                    createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{"amount":{"currency_code":"MXN","value":<?php echo floatval($total); ?>}}]
                    });
                    },

                    onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        
                        // Full available details
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                        // Show a success message within this page, e.g.
                        const element = document.getElementById('paypal-button-container');
                        //element.innerHTML = '';
                        //element.innerHTML = 'actura.php';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        actions.redirect('http://localhost:3000/factura.php');                        
                    });
                    },

                    onError: function(err) {
                    console.log(err);
                    }
                }).render('#paypal-button-container');
                }
                initPayPalButton();
            </script>
        </div>
    </div>
</main>

<?php
    incluirTemplate('footer');
?>