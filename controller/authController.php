<?php
session_start();

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/model/connection.php';

if(empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$nombre = '';
$apellido = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register')
        userRegister();

    if($action === 'login')
        userLogin();
}

require_once ROOT_PATH . '/view/loginRegister.php';
    
function userRegister(): void {
    global $errors, $nombre, $apellido, $email;

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token de seguridad inválido. Recarga la página e intenta de nuevo.';
        return;
    }

    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $contrasenaConfirmar = $_POST['confirmar'] ?? '';

    if(empty($nombre))
            $errors[] = 'El nombre es requerido.';
    if(empty($apellido))
            $errors[] = 'El apellido es requerido.';
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'El correo electrónico no es válido.';
    if(strlen($contrasena) < 8)
            $errors[] = 'La contraseña debe de tener al menos 8 caracteres.';
    if($contrasena !== $contrasenaConfirmar)
            $errors[] = 'Las contraseñas no coinciden';

    if(!empty($errors))
            return;

    try {
        $pdo = Database::getConnection();
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("EXEC dbo.sp_RegistrarUsuario
        @nombre = :nombre,
        @apellido = :apellido,
        @email = :email,
        @contrasena_hash = :hash");

        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':hash', $hash, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch();

        $_SESSION['usuarioID'] = (int)$result['usuarioID'];
        $_SESSION['nombre'] = $nombre;

        header('Location: /view/loginRegister.php');
        exit;
    } catch (PDOException $e) {
        if(str_contains($e->getMessage(), 'El email ya está registrado.'))
            $errors[] = 'Este correo electrónico ya está en uso.';
        else {
            error_log('Error: ' . $e->getMessage());
            $errors[] = 'Ocurrió un error al crear tu cuenta. Intentelo de nuevo.';
        }
    }
}


function userLogin(): void {
global $errors;

    $email = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($email) || empty($contrasena)) {
        $errors[] = 'Todos los campos son requeridos.';
        return;
    }

    try {
        $pdo  = Database::getConnection();
        $stmt = $pdo->prepare("EXEC dbo.sp_IniciarSesion @email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($contrasena, $usuario['contrasena_hash'])) {
            $errors[] = 'Correo electrónico o contraseña incorrectos.';
            return;
        }

        if (!$usuario['estaActivo']) {
            $errors[] = 'Esta cuenta ha sido desactivada.';
            return;
        }

        $_SESSION['usuarioID'] = $usuario['usuarioID'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header('Location: /view/index.php');
        exit;

    } catch (PDOException $e) {
        error_log('Error login: ' . $e->getMessage());
        $errors[] = 'Ocurrió un error al iniciar sesión. Inténtelo de nuevo.';
    }
}
?>