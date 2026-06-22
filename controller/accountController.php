<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once ROOT_PATH . '/model/codigoPostal.php';

header('Content-Type: application/json; charset=utf-8');

$codigoPostal = trim($_POST['codigoPostal'] ?? '');

if (!preg_match('/^\d{5}$/', $codigoPostal)) {
    http_response_code(400);
    echo json_encode(['exito' => false, 'error' => 'El código postal debe tener 5 dígitos.']);
    exit;
}

$direccion = obtenerDireccionPorCodigoPostal($codigoPostal);

if ($direccion === null) {
    http_response_code(404);
    echo json_encode(['exito' => false, 'error' => 'No se encontró información para ese código postal.']);
    exit;
}

echo json_encode([
    'exito' => true,
    'estado' => $direccion['estado'],
    'municipio' => $direccion['municipio'],
    'colonias' => $direccion['colonias'] ?? [],
]);
exit;