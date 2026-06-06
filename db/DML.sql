USE KicksAndJerseys;

--Datos base
INSERT INTO dbo.Usuarios_Roles(nombre) 
	VALUES ('Cliente'), ('Administrador');

INSERT INTO dbo.Productos_Categorias(nombre)
	VALUES ('Jersey'), ('Playeras'), ('Tacos'), ('Running'), ('Deportivos');

INSERT INTO dbo.Pedidos_Status(nombre)
	VALUES ('Pagado'), ('Enviado'), ('Entregado'), ('Cancelado');

INSERT INTO dbo.Transacciones_Tipos(nombre)
	VALUES ('Recarga'), ('Compra'), ('Devolución');

--Procedimientos Almacenados
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