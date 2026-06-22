<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/carritoController.php';

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

if (!isset($_POST['aceptaTerminos'])) {
    redirigirConError('Debes aceptar los términos y condiciones.');
}

$usuarioID = (int) $_SESSION['usuarioID'];
$items     = obtenerItemsCarritoConDetalles();

if (empty($items)) {
    redirigirConError('Tu carrito está vacío.');
}

$total = calcularResumenPedido($items)['total'];
$pdo   = Database::getConnection();

try {
    $pdo->beginTransaction();

    foreach ($items as $item) {
        $stmt = $pdo->prepare("{CALL dbo.sp_ReducirStockVariante (?, ?)}");
        $stmt->bindValue(1, $item['varianteID'], PDO::PARAM_INT);
        $stmt->bindValue(2, $item['cantidad'], PDO::PARAM_INT);
        $stmt->execute();

        if ((int) $stmt->fetchColumn() === 0) {
            throw new RuntimeException("Stock insuficiente para {$item['nombre']} (talla {$item['talla']}).");
        }
    }

    $stmtSaldo = $pdo->prepare("{CALL dbo.sp_DescontarSaldo (?, ?)}");
    $stmtSaldo->bindValue(1, $usuarioID, PDO::PARAM_INT);
    $stmtSaldo->bindValue(2, (string) $total, PDO::PARAM_STR);
    $stmtSaldo->execute();

    if ((int) $stmtSaldo->fetchColumn() === 0) {
        throw new RuntimeException('Saldo insuficiente. Recarga tu cartera para continuar.');
    }

    $ESTATUS_PAGADO = 2;
    $stmtPedido = $pdo->prepare("{CALL dbo.sp_CrearPedido (?, ?, ?)}");
    $stmtPedido->bindValue(1, $usuarioID, PDO::PARAM_INT);
    $stmtPedido->bindValue(2, $ESTATUS_PAGADO, PDO::PARAM_INT);
    $stmtPedido->bindValue(3, (string) $total, PDO::PARAM_STR);
    $stmtPedido->execute();
    $pedidoID = (int) $stmtPedido->fetchColumn();

    foreach ($items as $item) {
        $stmtDetalle = $pdo->prepare("{CALL dbo.sp_AgregarDetallePedido (?, ?, ?, ?, ?)}");
        $stmtDetalle->bindValue(1, $pedidoID, PDO::PARAM_INT);
        $stmtDetalle->bindValue(2, $item['productoID'], PDO::PARAM_INT);
        $stmtDetalle->bindValue(3, $item['varianteID'], PDO::PARAM_INT);
        $stmtDetalle->bindValue(4, $item['cantidad'], PDO::PARAM_INT);
        $stmtDetalle->bindValue(5, (string) $item['precioUnitario'], PDO::PARAM_STR);
        $stmtDetalle->execute();
    }

    $pdo->commit();
    vaciarCarrito();

    $_SESSION['carrito_success'] = "¡Compra realizada con éxito! Tu número de pedido es #{$pedidoID}.";
    header('Location: /view/carrito.php');
    exit;

} catch (Throwable $e) {
    $pdo->rollBack();
    error_log('Error al procesar pedido: ' . $e->getMessage());
    redirigirConError($e->getMessage());
}

function redirigirConError(string $mensaje): void {
    $_SESSION['carrito_error'] = $mensaje;
    header('Location: /view/carrito.php');
    exit;
}