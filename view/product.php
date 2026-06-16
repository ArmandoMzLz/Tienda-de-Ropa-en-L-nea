<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/product.css">

        <title>Kicks & Jerseys | </title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <div class="imagen-producto">
                <img>
            </div>
            <div class="datos-producto">
                <h1 name="nombre-producto">Nombre producto</h1>
                <p name="precio-producto">$999.99MXN</p>
                <div class="radio-group" name="selector-talla">
                    <label class="custom-radio">
                        <input type="radio" name="choice" value="CH" checked>
                        <span>CH</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="choice" value="M">
                        <span>M</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="choice" value="G">
                        <span>G</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="choice" value="XG">
                        <span>XG</span>
                    </label>
                </div>
                <div class="cantidad-producto">
                    <span id="btnAbajo">-</span>
                    <input id="cantidad" type="text" value="1">
                    <span id="btnArriba">+</span>
                </div>
                <button class="anadir-carrito-button">Añadir al carrito</button>
            </div>
            <br>
            <h1>Productos Similares</h1>
            <div class="productos-relacionados">
                
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/incQuant.js"></script>
    </body>
</html>