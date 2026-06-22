<?php
// controller/busquedaController.php
require_once ROOT_PATH . '/model/connection.php';

class BusquedaController {

    private function parsearParametros(): array {
        $busqueda = trim($_GET['busqueda'] ?? '');
        $ordenar = $_GET['ordenar']       ?? 'populares';
        $categoriaID = $_GET['categoria']     ?? null;
        $marcas = $_GET['marca']         ?? [];
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $ordenesPermitidos = ['populares', 'precio_asc', 'precio_desc'];
        if (!in_array($ordenar, $ordenesPermitidos, true)) {
            $ordenar = 'populares';
        }

        if ($categoriaID !== null) {
            $categoriaID = (int)$categoriaID;
            if ($categoriaID <= 0) {
                $categoriaID = null;
            }
        }

        $marcasLimpias = [];
        foreach ((array)$marcas as $marca) {
            $marcaLimpia = trim($marca);
            if ($marcaLimpia !== '' && preg_match('/^[\w\s]+$/u', $marcaLimpia)) {
                $marcasLimpias[] = strtolower($marcaLimpia);
            }
        }

        return [
            'busqueda' => $busqueda !== '' ? $busqueda : null,
            'ordenar' => $ordenar,
            'categoriaID' => $categoriaID,
            'marcas' => $marcasLimpias,
            'pagina' => $pagina,
        ];
    }

    private function buscarProductos(array $params): array {
        $pdo = Database::getConnection();

        $marcasCSV = !empty($params['marcas'])
            ? implode(',', $params['marcas'])
            : null;

        $sqlConOutput = "
            DECLARE @total INT;
            EXEC dbo.sp_ProductosBuscarGeneral
                @nombre = ?,
                @categoriaID = ?,
                @marcas = ?,
                @ordenar = ?,
                @pagina  = ?,
                @tamanoPagina = ?,
                @totalFilas = @total OUTPUT;
            SELECT @total AS totalFilas;
        ";

        $stmt = $pdo->prepare($sqlConOutput);
        $stmt->execute([
            $params['busqueda'],
            $params['categoriaID'],
            $marcasCSV,
            $params['ordenar'],
            $params['pagina'],
            20,
        ]);

        $productos = $stmt->fetchAll();

        $total = 0;
        if ($stmt->nextRowset()) {
            $fila = $stmt->fetch();
            $total = $fila ? (int)$fila['totalFilas'] : 0;
        }

        return [
            'productos'=> $productos,
            'total' => $total,
            'pagina' => $params['pagina'],
            'tamanoPagina' => 20,
            'totalPaginas' => $total > 0 ? (int)ceil($total / 20) : 0,
        ];
    }

    public function manejarBusqueda(): array {
        $params = $this->parsearParametros();

        if ($params['busqueda'] === null
            && $params['categoriaID'] === null
            && empty($params['marcas'])
        ) {
            return [
                'productos' => [],
                'total' => 0,
                'pagina' => 1,
                'tamanoPagina' => 20,
                'totalPaginas' => 0,
                'params' => $params,
            ];
        }

        try {
            $resultado           = $this->buscarProductos($params);
            $resultado['params'] = $params;
            return $resultado;
        } catch (PDOException $e) {
            error_log('[BusquedaController] ' . $e->getMessage());
            return [
                'productos' => [],
                'total' => 0,
                'pagina' => 1,
                'tamanoPagina' => 20,
                'totalPaginas' => 0,
                'params' => $params,
                'error' => 'Ocurrió un error al buscar productos. Intenta de nuevo.',
            ];
        }
    }
}