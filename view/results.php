<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/controller/busquedaController.php';

$controller = new BusquedaController();
$data = $controller->manejarBusqueda();

$productos = $data['productos'];
$total = $data['total'];
$params = $data['params'];
$totalPaginas = $data['totalPaginas'];
$pagina = $data['pagina'];
$error = $data['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/search.css">

        <title>Kicks & Jerseys | </title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main class="search-container">
            <header class="search-header">
                <h1>Resultados para:
                    <span>"<?= htmlspecialchars($params['busqueda'] ?? '') ?>"</span>
                </h1>
                <p><?= $total ?> producto<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?></p>
            </header>
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="search-layout">
                <aside class="filters-sidebar">
                    <form action="results.php" method="GET">
                        <input type="hidden" name="busqueda" value="<?= htmlspecialchars($params['busqueda'] ?? '') ?>">
                        <div class="filter-group">
                            <h3>Ordenar por</h3>
                            <select name="ordenar" id="ordenar">
                            <?php foreach ([
                                'populares'   => 'Más populares',
                                'precio_asc'  => 'Precio: Menor a Mayor',
                                'precio_desc' => 'Precio: Mayor a Menor',
                            ] as $valor => $etiqueta): ?>
                                <option value="<?= $valor ?>"
                                    <?= $params['ordenar'] === $valor ? 'selected' : '' ?>>
                                    <?= $etiqueta ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <h3>Categoría</h3>
                            <?php foreach ([
                            1 => 'Jerseys',
                            2 => 'Tenis',
                            3 => 'Deportivos',
                            4 => 'Para Correr',
                            ] as $id => $etiqueta): ?>
                            <label>
                                <input type="radio" name="categoria" value="<?= $id ?>"
                                    <?= $params['categoriaID'] === $id ? 'checked' : '' ?>>
                                    <?= $etiqueta ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="filter-group">
                            <h3>Marca</h3>
                            <?php foreach ([
                                'nike' => 'Nike',
                                'adidas' => 'Adidas',
                                'puma' => 'Puma',
                                'reebok' => 'Reebok',
                                'jordan' => 'Jordan',
                                'under armour' => 'Under Armour',
                            ] as $valor => $etiqueta): ?>
                                <label>
                                    <input type="checkbox" name="marca[]" value="<?= $valor ?>"
                                        <?= in_array($valor, $params['marcas'], true) ? 'checked' : '' ?>>
                                        <?= $etiqueta ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            <button type="submit" class="btn-filtrar">Aplicar Filtros</button>
                        </form>
                    </aside>
                        <section class="products-grid">
                        <?php if (empty($productos)): ?>
                            <p class="sin-resultados">No encontramos productos para tu búsqueda.</p>
                        <?php else: ?>
                            <?php foreach ($productos as $p): ?>
                                <article class="product-card">
                                    <div class="product-image">
                                        <img src="<?= htmlspecialchars($p['imagenBaseURL']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
                                    </div>
                                    <div class="product-info">
                                        <span class="brand"><?= htmlspecialchars($p['marca']) ?></span>
                                        <h2><?= htmlspecialchars($p['nombre']) ?></h2>
                                        <p class="price">$<?= number_format($p['precioBase'], 2) ?></p>
                                        <a href="product.php?id=<?= (int)$p['productoID'] ?>" class="btn-ver">Ver Detalles</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </section>
            </div>
                <?php if ($totalPaginas > 1): ?>
                <nav class="paginacion">
                        <?php if ($pagina > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">&laquo; Anterior </a>
                        <?php endif; ?>
                            <span>Página <?= $pagina ?> de <?= $totalPaginas ?></span>
                        <?php if ($pagina < $totalPaginas): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            </main>
        <?php include 'footer.php' ?>
    </body>
</html>