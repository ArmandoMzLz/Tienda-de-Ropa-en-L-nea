<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/registerController.php';

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
$contrasenaActual = $_POST['contrasenaActual'] ?? '';
$nuevaContrasena = $_POST['nuevaContrasena'] ?? '';
$confirmar = $_POST['confirmarContrasena'] ?? '';

if ($contrasenaActual === '' || $nuevaContrasena === '' || $confirmar === '') {
    redirigirConError('Todos los campos son obligatorios.');
}

if (strlen($nuevaContrasena) < 8) {
    redirigirConError('La nueva contraseña debe tener al menos 8 caracteres.');
}

if ($nuevaContrasena !== $confirmar) {
    redirigirConError('Las contraseñas nuevas no coinciden.');
}

$hashActual = obtenerContrasenaHashPorID($usuarioID);

if ($hashActual === null || !password_verify($contrasenaActual, $hashActual)) {
    redirigirConError('La contraseña actual es incorrecta.');
}

$nuevoHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

if (!actualizarContrasena($usuarioID, $nuevoHash)) {
    redirigirConError('Ocurrió un error al actualizar la contraseña. Intenta de nuevo.');
}

$_SESSION['account_success'] = 'Tu contraseña se actualizó correctamente.';
header('Location: /view/account.php');
exit;

function redirigirConError(string $mensaje): void {
    $_SESSION['account_error'] = $mensaje;
    header('Location: /view/account.php');
    exit;
}