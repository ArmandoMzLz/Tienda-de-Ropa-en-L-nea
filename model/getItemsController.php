<?php 
    require ROOT_PATH . '/model/connection.php';

    function buscarProductos(?int $categoriaID = null, ?string $marca = null, ?string $nombre = null, 
                            bool $soloDisponible = true, int $pagina = 1, int $tamanoPagina = 20) : array {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("{CALL dbo.sp_ProductosBuscar (?, ?, ?, ?, ?, ?)}");

            $stmt->bindValue(1, $categoriaID, $categoriaID === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindValue(2, $marca, $marca === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(3, $nombre, $nombre === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(4, $soloDisponible, PDO::PARAM_BOOL);
            $stmt->bindValue(5, $pagina, PDO::PARAM_INT);
            $stmt->bindValue(6, $tamanoPagina, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al buscar productos: ' . $e->getMessage());
            return [];
        }
    }

    function buscarProductosPorCategoria(int $categoriaID, int $limite = 12) : array {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("{CALL dbo.sp_ProductosPorCategoria (?, ?)}");

            $stmt->bindValue(1, $categoriaID, PDO::PARAM_INT);
            $stmt->bindValue(2, $limite, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al buscar productos: ' . $e->getMessage());
            return [];
        }
    }

    function buscarProductosSimilares(int $productoID, int $categoriaID, string $marca, int $limite = 6) : array {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("{CALL dbo.sp_ProductosSimilares (?, ?, ?, ?)}");

            $stmt->bindValue(1, $productoID, PDO::PARAM_INT);
            $stmt->bindValue(2, $categoriaID, PDO::PARAM_INT);
            $stmt->bindValue(3, $marca, PDO::PARAM_STR);
            $stmt->bindValue(4, $limite, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al buscar productos: ' . $e->getMessage());
            return [];
        }
    }

    function buscarProductosPorId(int $productoID): ?array {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("{CALL dbo.sp_ProductosPorID (?)}");

            $stmt->bindValue(1, $productoID, PDO::PARAM_INT);
            $stmt->execute();

            $producto = $stmt->fetch();
            if (!$producto) {
                return null;
            }

            $stmt->nextRowset();
            $producto['variantes'] = $stmt->fetchAll();

            return $producto;
        } catch (PDOException $e) {
            error_log('Error al obtener producto: ' . $e->getMessage());
            return null;
        }
    }

    function obtenerInventario(): array {
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("{CALL dbo.sp_ObtenerInventario}");
        $stmt->execute();
        $filas = $stmt->fetchAll();

        $productos = [];
        foreach ($filas as $fila) {
            $productoID = (int) $fila['productoID'];

            if (!isset($productos[$productoID])) {
                $productos[$productoID] = [
                    'productoID' => $productoID,
                    'marca' => $fila['marca'],
                    'nombre' => $fila['nombre'],
                    'precioBase' => (float) $fila['precioBase'],
                    'estaDisponible' => (bool) $fila['estaDisponible'],
                    'imagenBaseURL' => $fila['imagenBaseURL'],
                    'categoriaNombre' => $fila['categoriaNombre'],
                    'variantes' => [],
                    'stockTotal' => 0,
                ];
            }

            if ($fila['varianteID'] !== null) {
                $productos[$productoID]['variantes'][] = [
                    'varianteID' => (int) $fila['varianteID'],
                    'talla'      => $fila['talla'],
                    'stock'      => (int) $fila['stock'],
                ];
                $productos[$productoID]['stockTotal'] += (int) $fila['stock'];
            }
        }

        return array_values($productos);

    } catch (PDOException $e) {
        error_log('Error al obtener inventario: ' . $e->getMessage());
        return [];
    }
}
?>