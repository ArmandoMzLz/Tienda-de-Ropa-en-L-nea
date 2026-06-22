<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/index.css">
        
        <title>Kicks & Jerseys | Inicio</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <div class="hero-seccion-contenedor">
                <div class="hero-texto">
                    <h1>Deporte, Rendimiento y Distinción</h1><br>
                    <p>Acceda a una colección exclusiva de jerseys y calzado deportivo que combina tecnología, confort y diseño. Todo lo necesario para alcanzar sus objetivos.</p>
                </div>
                <div class="hero-img">
                    <img src="/images/Jersey_Visitante_Seleccion_Nacional_de_Mexico_26_Manga_Larga_Blanco_JZ2821_21_model.jpg">
                </div>
            </div>
            <div class="marca-contenedor">
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Adidas_logo.png">
                    </div>
                </div>
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Nike_logo.png">
                    </div>
                </div>
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Reebok_logo.png">
                    </div>
                </div>
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Puma_logo.png">
                    </div>
                </div>
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Jordan_logo.png">
                    </div>
                </div>
                <div class="marca">
                    <div class="marca-tarjeta">
                        <img src="/images/Under_armour_logo.png">
                    </div>
                </div>
            </div>
            <h1>Ropa</h1>
            <h1>Jerseys</h1>
                <?php
                    define('ROOT_PATH', dirname(__DIR__));
                    require_once ROOT_PATH . '/model/getItemsController.php';
                    require_once ROOT_PATH . '/controller/productCardController.php';

                    $categoriaID = (int) ($_GET['categoriaID'] ?? 1);
                    $productos = buscarProductosPorCategoria($categoriaID);
                ?>
                <div class="carrusel-contenedor">
                    <?php if (empty ($productos)) : ?>
                        <p>No hay productos disponibles.</p>
                    <?php else: ?>
                        <?php foreach (array_chunk($productos, 4) as $grupo): ?>
                            <div class="grupo">
                                <?php foreach ($grupo as $producto): ?>
                                    <?php renderTarjetaProducto($producto); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <h1>Calzado</h1>
            <div class="seccion-titulo">
                <h1>Tenis</h1>
                <button>Ver más ></button>
            </div>
                <?php
                    require_once ROOT_PATH . '/model/getItemsController.php';
                    require_once ROOT_PATH . '/controller/productCardController.php';

                    $categoriaID = (int) ($_GET['categoriaID'] ?? 2);
                    $productos = buscarProductosPorCategoria($categoriaID);
                ?>
                <div class="carrusel-contenedor">
                    <?php if (empty ($productos)) : ?>
                        <p>No hay productos disponibles.</p>
                    <?php else: ?>
                        <?php foreach (array_chunk($productos, 4) as $grupo): ?>
                            <div class="grupo">
                                <?php foreach ($grupo as $producto): ?>
                                    <?php renderTarjetaProducto($producto); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <div class="seccion-titulo">
                <h1>Deportivos</h1>
                <button>Ver más ></button>
            </div>
                <?php
                    require_once ROOT_PATH . '/model/getItemsController.php';
                    require_once ROOT_PATH . '/controller/productCardController.php';

                    $categoriaID = (int) ($_GET['categoriaID'] ?? 3);
                    $productos = buscarProductosPorCategoria($categoriaID);
                ?>
                <div class="carrusel-contenedor">
                    <?php if (empty ($productos)) : ?>
                        <p>No hay productos disponibles.</p>
                    <?php else: ?>
                        <?php foreach (array_chunk($productos, 4) as $grupo): ?>
                            <div class="grupo">
                                <?php foreach ($grupo as $producto): ?>
                                    <?php renderTarjetaProducto($producto); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <div class="seccion-titulo">
                <h1>Para Correr</h1>
                <button>Ver más ></button>
            </div>
                <?php
                    require_once ROOT_PATH . '/model/getItemsController.php';
                    require_once ROOT_PATH . '/controller/productCardController.php';

                    $categoriaID = (int) ($_GET['categoriaID'] ?? 4);
                    $productos = buscarProductosPorCategoria($categoriaID);
                ?>
                <div class="carrusel-contenedor">
                    <?php if (empty ($productos)) : ?>
                        <p>No hay productos disponibles.</p>
                    <?php else: ?>
                        <?php foreach (array_chunk($productos, 4) as $grupo): ?>
                            <div class="grupo">
                                <?php foreach ($grupo as $producto): ?>
                                    <?php renderTarjetaProducto($producto); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
        </main>
        <?php include 'footer.php' ?>
    </body>
</html>