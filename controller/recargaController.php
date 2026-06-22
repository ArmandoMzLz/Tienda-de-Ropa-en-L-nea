<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/walletController.php';

if (empty($_SESSION['usuarioID'])) {
    header('Location: /view/loginRegister.php');
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    die('Token de seguridad inválido. Recarga la página e intenta de nuevo.');
}

$usuarioID = (int) $_SESSION['usuarioID'];
$numeroTarjeta = preg_replace('/\s+/', '', $_POST['numeroTarjeta'] ?? '');
$codigoSeguridad = trim($_POST['codigoSeguridad'] ?? '');
$vencimiento = trim($_POST['vencimiento'] ?? '');
$titular = trim($_POST['titular'] ?? '');
$monto = (float) ($_POST['monto'] ?? 0);

if (!preg_match('/^\d{13,19}$/', $numeroTarjeta) || !pasaLuhn($numeroTarjeta)) {
    redirigirConError('El número de tarjeta no es válido.');
}

if (!preg_match('/^\d{3,4}$/', $codigoSeguridad)) {
    redirigirConError('El código de seguridad no es válido.');
}

if (!preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/', $vencimiento, $coincidencias)) {
    redirigirConError('La fecha de vencimiento debe tener el formato MM/AA.');
}

$mesVencimiento  = (int) $coincidencias[1];
$anioVencimiento = (int) $coincidencias[2] + 2000;
$finDeMes        = mktime(0, 0, 0, $mesVencimiento + 1, 0, $anioVencimiento);

if ($finDeMes < time()) {
    redirigirConError('La tarjeta está vencida.');
}

if ($titular === '') {
    redirigirConError('Ingresa el nombre del titular.');
}

if ($monto < 10 || $monto > 50000) {
    redirigirConError('El monto a recargar debe estar entre $10 y $50,000 MXN.');
}

$nuevoSaldo = recargarSaldo($usuarioID, $monto);

if ($nuevoSaldo === null) {
    redirigirConError('Ocurrió un error al procesar la recarga. Intenta de nuevo.');
}

$_SESSION['wallet_success'] = 'Recarga exitosa. Tu nuevo saldo es $' . number_format($nuevoSaldo, 2) . ' MXN.';
header('Location: /view/wallet.php');
exit;

function pasaLuhn(string $numero): bool {
    $suma = 0;
    $alternar = false;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $digito = (int) $numero[$i];

        if ($alternar) {
            $digito *= 2;
            if ($digito > 9) {
                $digito -= 9;
            }
        }

        $suma += $digito;
        $alternar = !$alternar;
    }

    return $suma % 10 === 0;
}

function redirigirConError(string $mensaje): void {
    $_SESSION['wallet_error'] = $mensaje;
    header('Location: /view/wallet.php');
    exit;
}