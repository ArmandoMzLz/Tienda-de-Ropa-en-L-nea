<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/carritoController.php';
require_once ROOT_PATH . '/controller/productCardController.php';

if (empty($_SESSION['usuarioID'])) {
    header('Location: /view/loginRegister.php');
    exit;
}

$items = obtenerItemsCarritoConDetalles();
$resumen = calcularResumenPedido($items);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/car.css">
        <title>Kicks & Jerseys | Carrito</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <h1>Carrito de Compras</h1>
        <main>
            <?php if (!empty($_SESSION['carrito_error']) || !empty($_SESSION['carrito_success'])): ?>
                <div class="mensaje-overlay" id="mensajeOverlay">
                    <div class="mensaje-contenedor">
                        <button class="cerrar" onclick="cerrarMensaje()">&times;</button>

                        <?php if (!empty($_SESSION['carrito_error'])): ?>
                            <p class="mensaje-error"><?= htmlspecialchars($_SESSION['carrito_error'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['carrito_error']); ?>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['carrito_success'])): ?>
                            <p class="mensaje-exito"><?= htmlspecialchars($_SESSION['carrito_success'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['carrito_success']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="carrito-contenedor">
                <div class="carrusel-contenedor">
                    <?php if (empty($items)): ?>
                        <p>No has agregado nada al carrito.</p>
                    <?php else: ?>
                        <?php foreach (array_chunk($items, 4) as $grupo): ?>
                            <div class="grupo">
                                <?php foreach ($grupo as $item): ?>
                                    <?php renderTarjetaCarrito($item); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="confirmar-compra-contenedor">
                <h3>Resumen del pedido</h3>
                <div class="resumen-compra">
                    <p>Sub total = <span><?= number_format($resumen['subtotal'], 2) ?> MXN</span></p>
                    <p>Costo de envío = <span><?= number_format($resumen['costoEnvio'], 2) ?> MXN</span></p>
                    <h4>Total = <span><?= number_format($resumen['total'], 2) ?> MXN</span></h4>
                </div>
                <form method="post" action="/controller/pedidoController.php" id="formFinalizarCompra">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="resumen-botones">
                        <label>
                            <input type="checkbox" name="aceptaTerminos" required>
                            Acepto los términos y condiciones.
                        </label><br>
                        <div class="botones-confirmar-compra">
                            <button class="finalizar-comprar-boton" type="submit" <?= empty($items) ? 'disabled' : '' ?>>Finalizar Compra</button>
                            <button class="seguir-comprando" type="button" onclick="location.href='/view/index.php'">Seguir Comprando</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/carrito.js"></script>
    </body>
</html>