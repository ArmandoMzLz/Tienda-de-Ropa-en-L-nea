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

function renderTarjetaCarrito(array $item): void {
    $varianteID = (int) $item['varianteID'];
    $marca = htmlspecialchars($item['marca'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8');
    $talla = htmlspecialchars($item['talla'], ENT_QUOTES, 'UTF-8');
    $imagen = htmlspecialchars($item['imagenBaseURL'], ENT_QUOTES, 'UTF-8');
    $subtotal = number_format($item['subtotal'], 2);
    $cantidad = (int) $item['cantidad'];
    $stockMax = (int) $item['stockDisponible'];
    ?>
    <div class="tarjeta tarjeta-carrito" data-variante-id="<?= $varianteID ?>">
        <img src="<?= $imagen ?>" alt="<?= $nombre ?>">
        <p><?= $marca ?></p>
        <h3><?= $nombre ?></h3>
        <p>Talla: <?= $talla ?></p>
        <div class="cantidad-carrito">
            <span class="incDecBtn restar-cantidad">-</span>
                <input type="text" class="input-cantidad-carrito" value="<?= $cantidad ?>" data-stock-max="<?= $stockMax ?>" readonly>
            <span class="incDecBtn sumar-cantidad">+</span>
        </div>
        <h4>$<?= $subtotal ?> MXN</h4>
        <button class="eliminar-del-carrito">Eliminar</button>
    </div>
    <?php
}