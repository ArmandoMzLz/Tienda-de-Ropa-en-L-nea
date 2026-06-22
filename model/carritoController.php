<?php
require_once ROOT_PATH . '/model/connection.php';


function obtenerDetalleVariante(int $varianteID): ? array {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ObtenerDetalleVariante (?)}");
        $stmt->bindValue(1, $varianteID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    } catch (PDOException $e) {
        error_log('Error al obtener detalle de variante: ' . $e->getMessage());
        return null;
    }
}

function obtenerCarrito(): array {
    return $_SESSION['carrito'] ?? [];
}

function agregarItemCarrito(int $varianteID, int $cantidad): void {
    $_SESSION['carrito'][$varianteID] = ($_SESSION['carrito'][$varianteID] ?? 0) + $cantidad;
}

function actualizarCantidadItemCarrito(int $varianteID, int $cantidad): void {
    if ($cantidad <= 0) {
        eliminarItemCarrito($varianteID);
        return;
    }
    $_SESSION['carrito'][$varianteID] = $cantidad;
}

function eliminarItemCarrito(int $varianteID): void {
    unset($_SESSION['carrito'][$varianteID]);
}

function vaciarCarrito(): void {
    $_SESSION['carrito'] = [];
}

function obtenerItemsCarritoConDetalles(): array {
    $items = [];

    foreach (obtenerCarrito() as $varianteID => $cantidad) {
        $detalle = obtenerDetalleVariante((int) $varianteID);

        if ($detalle === null || !$detalle['estaDisponible']) {
            eliminarItemCarrito((int) $varianteID);
            continue;
        }

        $cantidadFinal = min($cantidad, (int) $detalle['stockDisponible']);
        if ($cantidadFinal !== $cantidad) {
            actualizarCantidadItemCarrito((int) $varianteID, $cantidadFinal);
        }
        if ($cantidadFinal <= 0) {
            eliminarItemCarrito((int) $varianteID);
            continue;
        }

        $items[] = [
            'varianteID' => (int) $detalle['varianteID'],
            'productoID' => (int) $detalle['productoID'],
            'marca' => $detalle['marca'],
            'nombre' => $detalle['nombre'],
            'talla' => $detalle['talla'],
            'precioUnitario' => (float) $detalle['precioBase'],
            'imagenBaseURL' => $detalle['imagenBaseURL'],
            'cantidad' => $cantidadFinal,
            'stockDisponible'=> (int) $detalle['stockDisponible'],
            'subtotal' => round((float) $detalle['precioBase'] * $cantidadFinal, 2),
        ];
    }

    return $items;
}

function calcularResumenPedido(array $items): array {
    $subtotal   = array_sum(array_column($items, 'subtotal'));
    $costoEnvio = $subtotal > 0 && $subtotal < 999 ? 99.00 : 0.00;

    return [
        'subtotal' => round($subtotal, 2),
        'costoEnvio' => $costoEnvio,
        'total' => round($subtotal + $costoEnvio, 2),
    ];
}