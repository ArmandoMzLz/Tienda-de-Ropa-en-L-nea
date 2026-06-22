<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/connection.php';

function registrarUsuario(string $nombre, string $apellido, string $email, string $contrasenaHash) : array {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_RegistrarUsuario (?, ?, ?, ?)}");
        $stmt->bindValue(1, $nombre, PDO::PARAM_STR);
        $stmt->bindValue(2, $apellido, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $contrasenaHash, PDO::PARAM_STR);
        $stmt->execute();

        $usuarioID = $stmt->fetchColumn();
        return ['exito' => true, 'usuarioID' => (int) $usuarioID];

    } catch (PDOException $e) {
        if (($e->errorInfo[1] ?? null) == 50001) {
            return ['exito' => false, 'error' => 'El correo ya está registrado.'];
        }
        error_log('Error al registrar usuario: ' . $e->getMessage());
        return ['exito' => false, 'error' => 'Ocurrió un error al crear la cuenta. Intenta de nuevo.'];
    }
}

function obtenerUsuarioPorEmail(string $email) : ?array {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_IniciarSesion (?)}");

        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch();
        return $usuario ?: null;

    } catch (PDOException $e) {
        error_log('Error al consultar usuario: ' . $e->getMessage());
        return null;
    }
}

function obtenerPerfilUsuario(int $usuarioID): ?array {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ObtenerPerfilUsuario (?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->execute();

        $perfil = $stmt->fetch();
        return $perfil ?: null;

    } catch (PDOException $e) {
        error_log('Error al obtener perfil: ' . $e->getMessage());
        return null;
    }
}

function actualizarDireccionUsuario(int $usuarioID, string $direccion, string $numeroTelefono): bool {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ActualizarDireccionUsuario (?, ?, ?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->bindValue(2, $direccion, PDO::PARAM_STR);
        $stmt->bindValue(3, $numeroTelefono, PDO::PARAM_STR);
        return $stmt->execute();

    } catch (PDOException $e) {
        error_log('Error al actualizar dirección: ' . $e->getMessage());
        return false;
    }
}

function obtenerContrasenaHashPorID(int $usuarioID): ?string {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ObtenerContrasenaHash (?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->execute();

        $hash = $stmt->fetchColumn();
        return $hash !== false ? $hash : null;

    } catch (PDOException $e) {
        error_log('Error al obtener hash de contraseña: ' . $e->getMessage());
        return null;
    }
}

function actualizarContrasena(int $usuarioID, string $nuevoHash): bool {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ActualizarContrasena (?, ?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->bindValue(2, $nuevoHash, PDO::PARAM_STR);
        return $stmt->execute();

    } catch (PDOException $e) {
        error_log('Error al actualizar contraseña: ' . $e->getMessage());
        return false;
    }
}