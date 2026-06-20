<?php
    function renderTarjetaProducto(array $producto) : void {
        $id = (int) $producto['productoID'];
        $marca = htmlspecialchars($producto['marca'], ENT_QUOTES, 'UTF-8');
        $nombre = htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8');
        $precio = number_format((float) $producto['precioBase'], 2);
        $imagen = htmlspecialchars($producto['imagenBaseURL'], ENT_QUOTES, 'UTF-8');
    ?>
    <div class="tarjeta">
        <img src="<?= $imagen ?>" alt="<?= $nombre ?>">
        <p><?= $marca ?></p>
        <h3><?= $nombre ?></h3>
        <h4>$<?= $precio ?> MXN</h4>
        <button onclick="location.href='product.php?id=<?= $id ?> '">Ver detalles</button>
    </div>
<?php   
}