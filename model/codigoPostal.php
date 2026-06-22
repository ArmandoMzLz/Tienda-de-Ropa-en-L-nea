<?php
function obtenerDireccionPorCodigoPostal(string $codigoPostal): ? array {
    $apiKey = '';

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://postalia.com.mx/api/codigos-postales/{$codigoPostal}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer {$apiKey}",
        ],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($error) {
        error_log("Error cURL al consultar CP {$codigoPostal}: {$error}");
        return null;
    }

    if ($httpCode === 401) {
        error_log("Token de Postalia inválido o faltante.");
        return null;
    }

    if ($httpCode === 404) {
        return null;
    }

    if ($httpCode === 429) {
        error_log("Se alcanzó el límite diario de consultas a Postalia (CP {$codigoPostal}).");
        return null;
    }

    if ($httpCode !== 200) {
        error_log("Postalia regresó HTTP {$httpCode} para CP {$codigoPostal}");
        return null;
    }

    $datos = json_decode($response, true);

    if (!is_array($datos) || !isset($datos['estado'])) {
        return null;
    }

    $colonias = array_map(
        fn(array $colonia) => $colonia['nombre'] ?? '',
        $datos['colonias'] ?? []
    );

    return [
        'estado' => $datos['estado'],
        'municipio' => $datos['municipio'],
        'colonias' => array_values(array_filter($colonias)),
    ];
}