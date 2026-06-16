<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/wallet.css">

        <title>Kicks & Jerseys | Cartera</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <h1>Cartera</h1><br>
            <div class="saldo-actual">
                <p>Saldo actual:</p>
                <h1></h1>
            </div><br>
            <div class="metodo-pago">
                <form method="post">
                    <h1>Realizar una Recarga</h1>
                    <input class="tarjeta-input" type="text" placeholder="Número de Tarjeta"><br>
                    <input type="text" placeholder="Código de Seguridad">
                    <input type="text" placeholder="MM/AA">
                    <input type="text" placeholder="Titular">
                    <div class="cantidad-dinero">
                        <div class="fila-cantidad">
                            <span id="btnAbajo">-</span>
                            <div class="input-cantidad">
                                <input id="cantidad" type="text" value="1">
                            </div>
                            <span id="btnArriba">+</span>
                        </div>
                        <div class="fila-botones">
                            <span class="incButton" id="inc10">+10</span>
                            <span class="incButton" id="inc100">+100</span>
                            <span class="incButton" id="inc1000">+1,000</span>
                        </div>
                    </div>
                    <button type="submit">Hacer Recarga</button>
                </form>
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/wallet.js"></script>
    </body>
</html>