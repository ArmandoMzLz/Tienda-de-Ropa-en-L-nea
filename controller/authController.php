<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/controller/registerController.php';

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    die('Token de seguridad inválido. Recarga la página e intenta de nuevo.');
}

$accion = $_POST['action'] ?? '';

match ($accion) {
    'register' => manejarRegistro(),
    'login'    => manejarLogin(),
    default    => redirigir('/view/loginRegister.php'),
};

function manejarRegistro(): void {
    $nombre     = trim($_POST['nombre'] ?? '');
    $apellido   = trim($_POST['apellido'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar  = $_POST['confirmar'] ?? '';

    if ($nombre === '' || $apellido === '' || $email === '' || $contrasena === '') {
        redirigirConError('Todos los campos son obligatorios.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirigirConError('El correo electrónico no es válido.');
    }

    if (strlen($contrasena) < 8) {
        redirigirConError('La contraseña debe tener al menos 8 caracteres.');
    }

    if ($contrasena !== $confirmar) {
        redirigirConError('Las contraseñas no coinciden.');
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $resultado = registrarUsuario($nombre, $apellido, $email, $hash);

    if (!$resultado['exito']) {
        redirigirConError($resultado['error']);
    }

    $_SESSION['auth_success'] = 'Cuenta creada con éxito. Ahora puedes iniciar sesión.';
    redirigir('/view/loginRegister.php');
}

function manejarLogin(): void {
    $email      = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($email === '' || $contrasena === '') {
        redirigirConError('Ingresa tu correo y contraseña.');
    }

    $usuario = obtenerUsuarioPorEmail($email);

    if ($usuario === null || !password_verify($contrasena, $usuario['contrasena_hash'])) {
        redirigirConError('Correo o contraseña incorrectos.');
    }

    if ((int) $usuario['estaActivo'] === 0) {
        redirigirConError('Esta cuenta está desactivada. Contacta a soporte.');
    }

    session_regenerate_id(true);

    $_SESSION['usuarioID'] = (int) $usuario['usuarioID'];
    $_SESSION['nombre']    = $usuario['nombre'];
    $_SESSION['apellido']  = $usuario['apellido'];
    $_SESSION['rol']       = (int) $usuario['rol'];

    redirigir('/view/index.php');
}

function redirigirConError(string $mensaje): void {
    $_SESSION['auth_error'] = $mensaje;
    redirigir('/view/loginRegister.php');
}

function redirigir(string $ruta): void {
    header("Location: $ruta");
    exit;
}
?>