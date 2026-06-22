<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/controller/registerController.php';

if (empty($_SESSION['usuarioID'])) {
    header('Location: /view/loginRegister.php');
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    die('Token de seguridad inválido. Recarga la página e intenta de nuevo.');
}

$usuarioID = (int) $_SESSION['usuarioID'];
$estado = trim($_POST['estado'] ?? '');
$municipio = trim($_POST['municipio'] ?? '');
$colonia = trim($_POST['colonia'] ?? '');
$direccionDetalle = trim($_POST['direccionDetalle'] ?? '');
$numeroTelefono = trim($_POST['numeroTelefono'] ?? '');

if ($estado === '' || $municipio === '' || $colonia === '' || $direccionDetalle === '') {
    redirigirConError('Completa todos los campos de dirección.');
}

if ($numeroTelefono !== '' && !preg_match('/^\d{10}$/', $numeroTelefono)) {
    redirigirConError('El número de teléfono debe tener 10 dígitos.');
}

$direccionCompleta = "{$direccionDetalle}, {$colonia}, {$municipio}, {$estado}";

if (strlen($direccionCompleta) > 200) {
    redirigirConError('La dirección es demasiado larga.');
}

if (!actualizarDireccionUsuario($usuarioID, $direccionCompleta, $numeroTelefono)) {
    redirigirConError('Ocurrió un error al guardar tu dirección. Intenta de nuevo.');
}

$_SESSION['account_success'] = 'Tu dirección se guardó correctamente.';
header('Location: /view/account.php');
exit;

function redirigirConError(string $mensaje): void {
    $_SESSION['account_error'] = $mensaje;
    header('Location: /view/account.php');
    exit;
}