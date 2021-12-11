<?php
session_start();

require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="slider">
    <div class="glide">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <li class="glide__slide"><a href="tienda.php?id=7"><img class = "slider__img" src="/img/slider/blackest night.jpg" alt="bn"></a></li>
                <li class="glide__slide"><a href="tienda.php?id=8"><img class = "slider__img" src="/img/slider/flashpoint.jpg" alt="bn"></a></li>
                <li class="glide__slide"> <a href="tienda.php?id=9"><img class = "slider__img" src="/img/slider/marvel zombies.jpg" alt="bn"></a></li>
            </ul>
        </div>
        <div class="glide__bullets" data-glide-el="controls[nav]">
            <button class="glide__bullet" data-glide-dir="=0"></button>
            <button class="glide__bullet" data-glide-dir="=1"></button>
            <button class="glide__bullet" data-glide-dir="=2"></button>
        </div>
    </div>
</div>

<main class="contenedor">
    <h1>Nuestros Comics</h1>
    <?php incluirTemplate('comics'); ?>
</main>

<?php
incluirTemplate('footer');
?>