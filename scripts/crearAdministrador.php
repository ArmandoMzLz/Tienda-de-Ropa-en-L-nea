<?php
// ⚠️ Este script SOLO debe ejecutarse desde la terminal, nunca desde el navegador.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    die('Este script solo puede ejecutarse desde la línea de comandos.');
}

define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/model/connection.php';

function preguntar(string $mensaje): string {
    echo $mensaje;
    return trim(fgets(STDIN));
}

$nombre     = preguntar('Nombre: ');
$apellido   = preguntar('Apellido: ');
$email      = preguntar('Correo electrónico: ');
$contrasena = preguntar('Contraseña: ');

if ($nombre === '' || $apellido === '' || $email === '' || $contrasena === '') {
    echo "Todos los campos son obligatorios.\n";
    exit(1);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El correo electrónico no es válido.\n";
    exit(1);
}

if (strlen($contrasena) < 8) {
    echo "La contraseña debe tener al menos 8 caracteres.\n";
    exit(1);
}

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("{CALL dbo.sp_RegistrarAdministrador (?, ?, ?, ?)}");
    $stmt->bindValue(1, $nombre, PDO::PARAM_STR);
    $stmt->bindValue(2, $apellido, PDO::PARAM_STR);
    $stmt->bindValue(3, $email, PDO::PARAM_STR);
    $stmt->bindValue(4, $hash, PDO::PARAM_STR);
    $stmt->execute();

    $usuarioID = $stmt->fetchColumn();
    echo "\nAdministrador creado con éxito. usuarioID: {$usuarioID}\n";

} catch (PDOException $e) {
    if (($e->errorInfo[1] ?? null) == 50001) {
        echo "Error: ese correo ya está registrado.\n";
    } elseif (($e->errorInfo[1] ?? null) == 50002) {
        echo "Error: no existe el rol 'Administrador' en dbo.Usuarios_Roles.\n";
    } else {
        echo "Error inesperado: " . $e->getMessage() . "\n";
    }
    exit(1);
}