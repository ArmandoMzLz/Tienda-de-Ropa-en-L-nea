<?php 
    define('ROOTH_PATH', dirname(__DIR__));

    require ROOT_PATH . '/model/connection.php';

    function getProducts() {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo -> prepare("EXEC dbo.sp_ObtenerProductos");
        } catch (PDOException $e) {
            error_log('Error productos: ' . $e->getMessage());
        }
    }
?>