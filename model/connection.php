<?php
$serverName = "DESKTOP-UUD5G95\SQLEXPRESS";
$database = "KicksAndJerseys";
$username = "DESKTOP-UUD5G95\Administrador";

try {
    $conn = new PDO(
        "sqlsrv:server=$serverName;Database=$database;TrustServerCertificate=true", $username
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a SQL Server";
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>