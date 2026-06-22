<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/walletController.php';

if (empty($_SESSION['usuarioID'])) {
    header('Location: /view/loginRegister.php');
    exit;
}

$saldoActual = obtenerSaldo((int) $_SESSION['usuarioID']) ?? 0.0;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/css/wallet.css">

        <title>Kicks & Jerseys | Cartera</title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <main>
            <h1>Cartera</h1><br>
            <?php if (!empty($_SESSION['wallet_error']) || !empty($_SESSION['wallet_success'])): ?>
                <div class="mensaje-overlay" id="mensajeOverlay">
                    <div class="mensaje-contenedor">
                        <button class="cerrar" onclick="cerrarMensaje()">&times;</button>
                        <?php if (!empty($_SESSION['wallet_error'])): ?>
                            <p class="mensaje-error"><?= htmlspecialchars($_SESSION['wallet_error'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['wallet_error']); ?>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['wallet_success'])): ?>
                            <p class="mensaje-exito"><?= htmlspecialchars($_SESSION['wallet_success'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php unset($_SESSION['wallet_success']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="saldo-actual">
                <p>Saldo actual:</p>
                <h1>$<?= number_format($saldoActual, 2) ?> MXN</h1>
            </div><br>
            <div class="metodo-pago">
                <form method="post" action="/controller/recargaController.php" id="formRecarga">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <h1>Realizar una Recarga</h1>
                    <div>
                        <input class="tarjeta-input" type="text" id="numeroTarjeta" name="numeroTarjeta" placeholder="Número de Tarjeta" required>
                    </div>
                    <input type="text" id="codigoSeguridad" name="codigoSeguridad" placeholder="Código de Seguridad" maxlength="4" required>
                    <input type="text" id="vencimiento" name="vencimiento" placeholder="MM/AA" maxlength="5" required>
                    <input type="text" id="titular" name="titular" placeholder="Titular" required>
                    <div class="cantidad-dinero">
                        <div class="fila-cantidad">
                            <span class="incDecBtn" id="btnAbajo">-</span>
                            <div class="input-cantidad">
                                <input id="cantidad" name="monto" type="text" value="10">
                            </div>
                            <span class="incDecBtn" id="btnArriba">+</span>
                        </div>
                        <div class="fila-botones">
                            <span class="incButton incDecBtn" id="inc10">+10</span>
                            <span class="incButton incDecBtn" id="inc100">+100</span>
                            <span class="incButton incDecBtn" id="inc1000">+1,000</span>
                        </div>
                    </div>
                    <button class="recarga-boton" type="submit">Hacer Recarga</button>
                </form>
            </div>
        </main>
        <?php include 'footer.php' ?>
        <script src="/js/wallet.js"></script>
    </body>
</html>