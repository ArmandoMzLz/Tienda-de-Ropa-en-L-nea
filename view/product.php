<?php 
    require_once dirname(__DIR__) . '/bootstrap.php';
    require_once ROOT_PATH . '/controller/getItemsController.php';
    require_once ROOT_PATH . '/controller/productCardController.php';

    $productoID = (int) ($_GET['id' ?? 0]);
    $producto = buscarProductosPorId($productoID);

    if($producto === null) {
        header('Location: index.php');
        exit;
    }

    $similares = buscarProductosSimilares($producto['productoID'], $producto['categoriaID'], $producto['marca']);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/product.css">

        <title>Kicks & Jerseys | <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <div class="contenedor-principal">
            <div class="imagen-producto">
                <img src="<?= htmlspecialchars($producto['imagenBaseURL'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"">
            </div>
            <div class="datos-producto">
                <h1 name="nombre-producto"><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p name="precio-producto">$<?= number_format((float) $producto['precioBase'], 2) ?> MXN</p>
                <div class="selector-talla">
                    <?php foreach ($producto['variantes'] as $variante): ?>
                        <?php if ($variante['cantidad'] > 0): ?>
                            <?php
                                $talla = htmlspecialchars($variante['talla'], ENT_QUOTES, 'UTF-8');
                                $inputId = 'talla-' . $talla;
                            ?>
                            <input type="radio" name="talla" id="<?= $inputId ?>" value="<?= $talla ?>" data-stock="<?= (int) $variante['cantidad'] ?>" class="talla-radio">
                            <label for="<?= $inputId ?>" class="talla-label"><?= $talla ?></label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="cantidad-producto">
                    <span id="btnAbajo">-</span>
                    <input id="cantidad" type="text" value="1">
                    <span id="btnArriba">+</span>
                </div>
                <button class="anadir-carrito-button">Añadir al carrito</button>
            </div>
            </div>
            <h1>Productos Similares</h1>
             <div class="carrusel-contenedor">
                <?php if (empty($similares)): ?>
                    <p>No hay productos similares disponibles.</p>
                <?php else: ?>
                    <?php foreach (array_chunk($similares, 4) as $grupo): ?>
                        <div class="grupo">
                            <?php foreach ($grupo as $similar): ?>
                                <?php renderTarjetaProducto($similar); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/product.js"></script>
    </body>
</html>