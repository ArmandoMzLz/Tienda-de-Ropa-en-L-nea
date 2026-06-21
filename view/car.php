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
            <div class="carrito-contenedor">

            </div>
            <div class="confirmar-compra-contenedor">
                <h3>Resumen del pedido</h3>
                <div class="resumen-compra">
                    <p>Sub total</p>
                    <p>Costo de envío</p>
                    <p>Descuento</p>
                    <h4>Total</h4>
                </div>
                <div class="resumen-botones">
                    <label>
                        <input type="checkbox">
                        Acepto los términos y condiciones.
                    </label><br>
                    <button class="finalizar-comprar-boton">Finalizar Compra</button><br>   
                    <button class="seguir-comprando">Seguir Comprando</button>
                </div>
            </div>
        </main>
        <?php include 'footer.php' ?>
    </body>
</html>