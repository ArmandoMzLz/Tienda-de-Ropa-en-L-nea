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