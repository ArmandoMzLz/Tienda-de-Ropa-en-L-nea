<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/carritoController.php';

header('Content-Type: application/json; charset=utf-8');

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode(['exito' => false, 'error' => 'Token de seguridad inválido.']);
    exit;
}

$accion = $_POST['accion'] ?? '';
$varianteID = (int) ($_POST['varianteID'] ?? 0);
$cantidad = (int) ($_POST['cantidad'] ?? 0);

switch ($accion) {
    case 'agregar':
        $detalle = obtenerDetalleVariante($varianteID);
        if ($detalle === null || !$detalle['estaDisponible']) {
            http_response_code(404);
            echo json_encode(['exito' => false, 'error' => 'El producto no está disponible.']);
            exit;
        }
        if ($cantidad <= 0 || $cantidad > (int) $detalle['stockDisponible']) {
            http_response_code(400);
            echo json_encode(['exito' => false, 'error' => 'Cantidad no disponible en stock.']);
            exit;
        }
        agregarItemCarrito($varianteID, $cantidad);
        break;

    case 'actualizar':
        actualizarCantidadItemCarrito($varianteID, $cantidad);
        break;

    case 'eliminar':
        eliminarItemCarrito($varianteID);
        break;

    default:
        http_response_code(400);
        echo json_encode(['exito' => false, 'error' => 'Acción no reconocida.']);
        exit;
}

$items = obtenerItemsCarritoConDetalles();
echo json_encode([
    'exito' => true,
    'totalArticulos' => array_sum(array_column($items, 'cantidad')),
    'resumen' => calcularResumenPedido($items),
]);
exit;