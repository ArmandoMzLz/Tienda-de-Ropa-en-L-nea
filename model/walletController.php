<?php
require_once ROOT_PATH . '/model/connection.php';

function obtenerSaldo(int $usuarioID): ?float {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ObtenerSaldo (?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->execute();

        $saldo = $stmt->fetchColumn();
        return $saldo !== false ? (float) $saldo : null;

    } catch (PDOException $e) {
        error_log('Error al obtener saldo: ' . $e->getMessage());
        return null;
    }
}

function recargarSaldo(int $usuarioID, float $monto): ?float {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_RecargarSaldo (?, ?)}");
        $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
        $stmt->bindValue(2, (string) $monto, PDO::PARAM_STR);
        $stmt->execute();

        $nuevoSaldo = $stmt->fetchColumn();
        return $nuevoSaldo !== false ? (float) $nuevoSaldo : null;

    } catch (PDOException $e) {
        error_log('Error al recargar saldo: ' . $e->getMessage());
        return null;
    }
}