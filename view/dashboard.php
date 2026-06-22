<?php
require_once dirname(__DIR__) . '/bootstrap.php';

if (empty($_SESSION['usuarioID']) || (int) ($_SESSION['rol'] ?? 0) !== 2) {
    header('Location: /view/loginRegister.php');
    exit;
}

require_once ROOT_PATH . '/model/getItemsController.php';

$productos = obtenerInventario();

$totalProductos    = count($productos);
$productosSinStock = count(array_filter($productos, fn($p) => $p['stockTotal'] === 0));
$valorInventario   = array_sum(array_map(fn($p) => $p['precioBase'] * $p['stockTotal'], $productos));
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/dashboard.css">

        <title>Kicks & Jerseys | Dashboard</title>
    </head>
    <body>
        <header class="dashboard-header">
            <h1>Panel de Administración</h1>
            <nav>
                <span>Hola, <?= htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8') ?></span>
                <a href="/controller/logoutController.php">Cerrar Sesión</a>
            </nav>
        </header>

        <main class="dashboard-main">
            <section class="resumen-stats">
                <div class="stat-card">
                    <p>Total de productos</p>
                    <h2><?= $totalProductos ?></h2>
                </div>
                <div class="stat-card <?= $productosSinStock > 0 ? 'stat-alerta' : '' ?>">
                    <p>Productos sin stock</p>
                    <h2><?= $productosSinStock ?></h2>
                </div>
                <div class="stat-card">
                    <p>Valor total del inventario</p>
                    <h2>$<?= number_format($valorInventario, 2) ?> MXN</h2>
                </div>
            </section>

            <section class="inventario-tabla">
                <h2>Inventario</h2>

                <?php if (empty($productos)): ?>
                    <p>No hay productos registrados.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Tallas y stock</th>
                                <th>Stock total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                                <tr class="<?= $producto['stockTotal'] === 0 ? 'fila-sin-stock' : '' ?>">
                                    <td>
                                        <img src="<?= htmlspecialchars($producto['imagenBaseURL'], ENT_QUOTES, 'UTF-8') ?>"
                                             alt="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"
                                             class="miniatura-producto">
                                    </td>
                                    <td>
                                        <span class="marca-producto"><?= htmlspecialchars($producto['marca'], ENT_QUOTES, 'UTF-8') ?></span><br>
                                        <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td><?= htmlspecialchars($producto['categoriaNombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>$<?= number_format($producto['precioBase'], 2) ?></td>
                                    <td>
                                        <span class="badge <?= $producto['estaDisponible'] ? 'badge-disponible' : 'badge-no-disponible' ?>">
                                            <?= $producto['estaDisponible'] ? 'Disponible' : 'No disponible' ?>
                                        </span>
                                    </td>
                                    <td class="celda-tallas">
                                        <?php if (empty($producto['variantes'])): ?>
                                            <span class="sin-tallas">Sin tallas registradas</span>
                                        <?php else: ?>
                                            <?php foreach ($producto['variantes'] as $variante): ?>
                                                <span class="talla-stock <?= $variante['stock'] < 5 ? 'stock-bajo' : '' ?>">
                                                    <?= htmlspecialchars($variante['talla'], ENT_QUOTES, 'UTF-8') ?>: <?= $variante['stock'] ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="stock-total <?= $producto['stockTotal'] === 0 ? 'stock-bajo' : '' ?>">
                                        <?= $producto['stockTotal'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </body>
</html>