USE KicksAndJerseys;
GO

--Usuarios
CREATE PROCEDURE dbo.sp_RegistrarUsuario
	@nombre VARCHAR(50),
	@apellido VARCHAR(50),
	@email VARCHAR(100),
	@contrasena_hash VARCHAR(255)
AS
BEGIN
	SET NOCOUNT ON;

	IF EXISTS(SELECT 1 FROM dbo.Usuarios_Login WHERE email = @email)
	BEGIN
		THROW 50001, 'El email ya está registrado.', 1;
		RETURN;
	END

	DECLARE @usuarioID INT;
	DECLARE @rolDefault INT;

	SELECT @rolDefault = rolID
	FROM dbo.Usuarios_Roles
	WHERE nombre = 'Cliente';

	IF @rolDefault IS NULL
	BEGIN
		THROW 50002, 'No existe un rol por defecto configurado.', 1;
		RETURN;
	END

	BEGIN TRANSACTION;
	BEGIN TRY
		INSERT INTO dbo.Usuarios(nombre, apellido, estaActivo, rol)
		VALUES(@nombre, @apellido, 1, @rolDefault);

		SET @usuarioID = SCOPE_IDENTITY();

		INSERT INTO dbo.Usuarios_Login(usuarioID, email, contrasena_hash)
		VALUES(@usuarioID, @email, @contrasena_hash);

		INSERT INTO dbo.Usuario_Cartera(usuarioID, balance)
		VALUES(@usuarioID, 0.00);

		COMMIT TRANSACTION;

		SELECT @usuarioID AS usuarioID;
	END TRY
	BEGIN CATCH
		IF @@TRANCOUNT > 0
			ROLLBACK TRANSACTION;
		THROW;
	END CATCH;
END;
GO

CREATE PROCEDURE dbo.sp_IniciarSesion
    @email VARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        u.usuarioID,
        u.nombre,
        u.apellido,
        u.rol,
        u.estaActivo,
        ul.contrasena_hash
    FROM dbo.Usuarios u
    INNER JOIN dbo.Usuarios_Login ul
        ON u.usuarioID = ul.usuarioID
    WHERE ul.email = @email;
END;
GO

CREATE PROCEDURE dbo.sp_ObtenerPerfilUsuario
    @usuarioID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        u.usuarioID,
        u.nombre,
        u.apellido,
        u.direccion,
        u.numeroTelefono,
        ul.email
    FROM       dbo.Usuarios u
    INNER JOIN dbo.Usuarios_Login ul ON ul.usuarioID = u.usuarioID
    WHERE u.usuarioID = @usuarioID;
END;
GO

CREATE PROCEDURE dbo.sp_ActualizarDireccionUsuario
    @usuarioID INT,
    @direccion VARCHAR(200),
    @numeroTelefono VARCHAR(12)
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE dbo.Usuarios
    SET direccion = @direccion,
        numeroTelefono = @numeroTelefono
    WHERE usuarioID = @usuarioID;
END;
GO

CREATE PROCEDURE dbo.sp_ObtenerContrasenaHash
    @usuarioID INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT contrasena_hash FROM dbo.Usuarios_Login WHERE usuarioID = @usuarioID;
END;
GO

CREATE PROCEDURE dbo.sp_ActualizarContrasena
    @usuarioID INT,
    @contrasena_hash VARCHAR(255)
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE dbo.Usuarios_Login
    SET contrasena_hash = @contrasena_hash
    WHERE usuarioID = @usuarioID;
END;
GO

CREATE PROCEDURE dbo.sp_ObtenerSaldo
    @usuarioID INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT balance FROM dbo.Usuario_Cartera WHERE usuarioID = @usuarioID;
END;
GO

CREATE PROCEDURE dbo.sp_RecargarSaldo
    @usuarioID INT,
    @monto DECIMAL(10,2)
AS
BEGIN
    SET NOCOUNT ON;

    IF @monto <= 0
    BEGIN
        THROW 50003, 'El monto a recargar debe ser mayor a cero.', 1;
        RETURN;
    END

    UPDATE dbo.Usuario_Cartera
    SET balance = balance + @monto
    WHERE usuarioID = @usuarioID;

    SELECT balance FROM dbo.Usuario_Cartera WHERE usuarioID = @usuarioID;
END;
GO

--Productos
CREATE INDEX ix_ProductosCategoriaMarca
	ON dbo.Productos (categoriaID, marca)
	INCLUDE (nombre, precioBase, estaDisponible, imagenBaseURL);
GO

CREATE INDEX ix_VariantesProductoID
	ON dbo.Productos_Variantes (productoID)
	INCLUDE (cantidad);
GO

CREATE PROCEDURE dbo.sp_ProductosBuscar
	@categoriaID INT = NULL,
	@marca VARCHAR(30) = NULL,
	@nombre VARCHAR(100) = NULL,
	@soloDisponible BIT = 1,
	@pagina INT = 1,
	@tamanoPagina INT = 20
AS 
BEGIN
	SET NOCOUNT ON;

	SELECT
		p.productoID,
		p.marca,
		p.nombre,
		p.precioBase,
		p.estaDisponible,
		p.imagenBaseURL,
		c.nombre AS categoria,
		SUM(v.cantidad) AS stockTotal
	FROM dbo.Productos p
	INNER JOIN dbo.Productos_Categorias c ON c.categoriaID = p.categoriaID
	LEFT JOIN dbo.Productos_Variantes v ON v.productoID = p.productoID
	WHERE (
		@categoriaID IS NULL OR p.categoriaID = @categoriaID)
		AND (@marca IS NULL OR p.marca LIKE '%' + @marca + '%')
		AND (@nombre IS NULL OR p.nombre LIKE '%' + @nombre + '%')
		AND (@soloDisponible = 0 OR p.estaDisponible = 1)
	GROUP BY
		p.productoID, p.marca, p.nombre, p.precioBase, p.estaDisponible, p.imagenBaseURL, c.nombre
	ORDER BY p.nombre
	OFFSET (@pagina - 1) * @tamanoPagina ROWS
	FETCH NEXT @tamanoPagina ROWS ONLY
	OPTION (RECOMPILE);
END;
GO

CREATE PROCEDURE dbo.sp_ProductosPorCategoria
	@categoriaID INT,
	@limite INT = 12
AS 
BEGIN
	SET NOCOUNT ON;

	SELECT TOP (@limite)
		p.productoID,
		p.marca,
		p.nombre,
		p.precioBase,
		p.imagenBaseURL,
		SUM(v.cantidad) AS stockTotal
	FROM dbo.Productos p
	LEFT JOIN dbo.Productos_Variantes v ON v.productoID = p.productoID
	WHERE p.categoriaID = @categoriaID
		AND p.estaDisponible = 1
	GROUP BY
		p.productoID, p.marca, p.nombre, p.precioBase, p.imagenBaseURL
	ORDER BY p.nombre;
END;
GO

CREATE PROCEDURE dbo.sp_ProductosSimilares
	@productoID INT,
	@categoriaID INT,
	@marca VARCHAR(30),
	@limite INT = 6
AS 
BEGIN
	SET NOCOUNT ON;

	SELECT TOP(@limite)
		p.productoID,
		p.marca,
		p.nombre,
		p.precioBase,
		p.imagenBaseURL,
		CASE WHEN p.marca = @marca THEN 0 ELSE 1 END AS prioridad
	FROM dbo.Productos p
	WHERE p.categoriaID = @categoriaID
		AND p.productoID <> @productoID
		AND p.estaDisponible = 1
	ORDER BY prioridad, p.nombre
END;
GO

CREATE PROCEDURE dbo.sp_ProductosPorID
    @productoID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        p.productoID,
        p.categoriaID,
        p.marca,
        p.nombre,
        p.precioBase,
        p.estaDisponible,
        p.imagenBaseURL,
        c.nombre AS categoriaNombre
    FROM       dbo.Productos            p
    INNER JOIN dbo.Productos_Categorias c ON c.categoriaID = p.categoriaID
    WHERE p.productoID = @productoID;

    SELECT
        varianteID,
        talla,
        cantidad
    FROM dbo.Productos_Variantes
    WHERE productoID = @productoID
    ORDER BY talla;
END;
GO

CREATE PROCEDURE dbo.sp_ProductosBuscarGeneral
    @nombre       VARCHAR(100) = NULL,
    @categoriaID  INT          = NULL,
    @marcas       VARCHAR(500) = NULL,
    @ordenar      VARCHAR(20)  = 'populares',
    @pagina       INT          = 1,
    @tamanoPagina INT          = 20,
    @totalFilas   INT          OUTPUT
AS
BEGIN
    SET NOCOUNT ON;

    CREATE TABLE #Marcas (marca VARCHAR(30));

    IF @marcas IS NOT NULL AND LTRIM(RTRIM(@marcas)) <> ''
    BEGIN
        INSERT INTO #Marcas (marca)
        SELECT LTRIM(RTRIM(value))
        FROM STRING_SPLIT(@marcas, ',')
        WHERE LTRIM(RTRIM(value)) <> '';
    END

    SELECT @totalFilas = COUNT(DISTINCT p.productoID)
    FROM dbo.Productos p
    INNER JOIN dbo.Productos_Categorias c ON c.categoriaID = p.categoriaID
    WHERE
        p.estaDisponible = 1
        AND (@nombre      IS NULL OR p.nombre LIKE '%' + @nombre + '%')
        AND (@categoriaID IS NULL OR p.categoriaID = @categoriaID)  -- Comparación directa por ID
        AND (
            NOT EXISTS (SELECT 1 FROM #Marcas)
            OR LOWER(p.marca) IN (SELECT marca FROM #Marcas)
        );

    SELECT
        p.productoID,
        p.marca,
        p.nombre,
        p.precioBase,
        p.imagenBaseURL,
        c.nombre AS categoria,
        COALESCE(SUM(v.cantidad), 0) AS stockTotal
    FROM dbo.Productos p
    INNER JOIN dbo.Productos_Categorias c ON c.categoriaID = p.categoriaID
    LEFT  JOIN dbo.Productos_Variantes  v ON v.productoID  = p.productoID
    WHERE
        p.estaDisponible = 1
        AND (@nombre      IS NULL OR p.nombre LIKE '%' + @nombre + '%')
        AND (@categoriaID IS NULL OR p.categoriaID = @categoriaID)
        AND (
            NOT EXISTS (SELECT 1 FROM #Marcas)
            OR LOWER(p.marca) IN (SELECT marca FROM #Marcas)
        )
    GROUP BY
        p.productoID, p.marca, p.nombre,
        p.precioBase, p.imagenBaseURL, c.nombre
    ORDER BY
        CASE WHEN @ordenar = 'precio_asc'  THEN p.precioBase END ASC,
        CASE WHEN @ordenar = 'precio_desc' THEN p.precioBase END DESC,
        CASE WHEN @ordenar = 'populares'   THEN COALESCE(SUM(v.cantidad), 0) END DESC,
        p.nombre ASC
    OFFSET (@pagina - 1) * @tamanoPagina ROWS
    FETCH NEXT @tamanoPagina ROWS ONLY
    OPTION (RECOMPILE);

    DROP TABLE #Marcas;
END;
GO

CREATE PROCEDURE dbo.sp_ObtenerInventario
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        p.productoID,
        p.marca,
        p.nombre,
        p.precioBase,
        p.estaDisponible,
        p.imagenBaseURL,
        c.nombre AS categoriaNombre,
        v.varianteID,
        v.talla,
        v.cantidad AS stock
    FROM       dbo.Productos p
    INNER JOIN dbo.Productos_Categorias c ON c.categoriaID = p.categoriaID
    LEFT  JOIN dbo.Productos_Variantes v  ON v.productoID = p.productoID
    ORDER BY p.nombre, v.talla;
END;
GO

--Pedidos
CREATE PROCEDURE dbo.sp_ObtenerDetalleVariante
    @varianteID INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        v.varianteID, v.talla, v.cantidad AS stockDisponible,
        p.productoID, p.marca, p.nombre, p.precioBase, p.imagenBaseURL, p.estaDisponible
    FROM dbo.Productos_Variantes v
    INNER JOIN dbo.Productos p ON p.productoID = v.productoID
    WHERE v.varianteID = @varianteID;
END;
GO

CREATE PROCEDURE dbo.sp_CrearPedido
    @usuarioID INT, 
    @estatus INT, 
    @total DECIMAL(10,2)
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO dbo.Pedidos (usuarioID, estatus, total, fecha)
    VALUES (@usuarioID, @estatus, @total, GETDATE());
    SELECT SCOPE_IDENTITY() AS pedidoID;
END;
GO

CREATE PROCEDURE dbo.sp_AgregarDetallePedido
    @pedidoID INT, 
    @productoID INT, 
    @varianteID INT, 
    @cantidad INT, 
    @precioUnitario DECIMAL(10,2)
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO dbo.Pedidos_Detalles (pedidoID, productoID, varianteID, cantidad, precioUnitario)
    VALUES (@pedidoID, @productoID, @varianteID, @cantidad, @precioUnitario);
END;
GO

CREATE PROCEDURE dbo.sp_ReducirStockVariante
    @varianteID INT, 
    @cantidad INT
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE dbo.Productos_Variantes
    SET cantidad = cantidad - @cantidad
    WHERE varianteID = @varianteID AND cantidad >= @cantidad;
    SELECT @@ROWCOUNT AS filasAfectadas; -- 0 = no había suficiente stock
END;
GO

CREATE PROCEDURE dbo.sp_DescontarSaldo
    @usuarioID INT, 
    @monto DECIMAL(10,2)
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE dbo.Usuario_Cartera
    SET balance = balance - @monto
    WHERE usuarioID = @usuarioID AND balance >= @monto;
    SELECT @@ROWCOUNT AS filasAfectadas; -- 0 = saldo insuficiente
END;
GO