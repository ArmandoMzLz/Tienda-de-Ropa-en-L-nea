CREATE DATABASE KicksAndJerseys;
GO

USE KicksAndJerseys;
GO

--Usuarios
CREATE TABLE dbo.Usuarios_Roles (
	rolID INT IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(15) NOT NULL
);
GO

CREATE TABLE dbo.Usuarios (
	usuarioID INT IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(50) NOT NULL,
	apellido VARCHAR(50) NOT NULL,
	direccion VARCHAR(200),
	numeroTelefono VARCHAR(12),
	estaActivo BIT NOT NULL,
	rol INT NOT NULL,
	CONSTRAINT FK_rol
	FOREIGN KEY (rol)
		REFERENCES dbo.Usuarios_Roles(rolID)
);
GO

CREATE TABLE dbo.Usuarios_Login (
	usuarioID INT NOT NULL PRIMARY KEY,
	email VARCHAR(100) NOT NULL,
	contrasena_hash VARCHAR(255) NOT NULL,
	CONSTRAINT FK_usuario_login
	FOREIGN KEY(usuarioID)
		REFERENCES dbo.Usuarios(usuarioID)
);
GO

CREATE TABLE dbo.Usuario_Cartera (
	carteraID INT IDENTITY(1,1) PRIMARY KEY,
	usuarioID INT NOT NULL,
	balance DECIMAL(10,2) NOT NULL,
	CONSTRAINT FK_usuario_cartera
	FOREIGN KEY(usuarioID)
		REFERENCES dbo.Usuarios(usuarioID)
);
GO

--Productos
CREATE TABLE dbo.Productos_Categorias(
	categoriaID INT IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL
);
GO

CREATE TABLE dbo.Productos (
	productoID INT IDENTITY(1,1) PRIMARY KEY,
	categoriaID INT NOT NULL,
	marca VARCHAR(30) NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	precioBase DECIMAL(10,2) NOT NULL,
	estaDisponible BIT NOT NULL,
	imagenBaseURL VARCHAR(200) NOT NULL,
	CONSTRAINT FK_producto_categoria
	FOREIGN KEY(categoriaID)
		REFERENCES dbo.Productos_Categorias(categoriaID)
);
GO

CREATE TABLE dbo.Productos_Variantes(
	varianteID INT IDENTITY(1,1) PRIMARY KEY,
	productoID INT NOT NULL,
	talla CHAR(2) NOT NULL,
	cantidad INT NOT NULL,
	CONSTRAINT FK_producto_variante
	FOREIGN KEY(productoID)
		REFERENCES dbo.Productos(productoID)
);
GO

--Pedidos
CREATE TABLE dbo.Pedidos_Status(
	statusID INT IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(20) NOT NULL
);
GO

CREATE TABLE dbo.Pedidos(
	pedidoID INT IDENTITY(1,1) PRIMARY KEY,
	usuarioID INT NOT NULL,
	estatus INT NOT NULL,
	total DECIMAL(10,2) NOT NULL,
	fecha DATETIME NOT NULL,
	CONSTRAINT FK_usuario_pedido
	FOREIGN KEY(usuarioID)
		REFERENCES dbo.Usuarios(usuarioID),
	CONSTRAINT FK_estatus
	FOREIGN KEY(estatus)
		REFERENCES dbo.Pedidos_Status(statusID)
);
GO

CREATE TABLE dbo.Pedidos_Detalles(
	detalleID INT IDENTITY (1,1) PRIMARY KEY,
	pedidoID INT NOT NULL,
	productoID INT NOT NULL,
	varianteID INT NOT NULL,
	cantidad INT NOT NULL,
	precioUnitario DECIMAL(10,2) NOT NULL
	CONSTRAINT FK_pedido_detalles
	FOREIGN KEY(pedidoID)
		REFERENCES dbo.Pedidos(pedidoID),
	CONSTRAINT FK_producto_pedido
	FOREIGN KEY(productoID)
		REFERENCES dbo.Productos(productoID),
	CONSTRAINT FK_variante_pedido
	FOREIGN KEY(varianteID)
		REFERENCES dbo.Productos_Variantes(varianteID)
);
GO

--Transacciones
CREATE TABLE dbo.Transacciones_Tipos(
	tipoID INT IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(15) NOT NULL
);
GO

CREATE TABLE dbo.Transacciones(
	transaccionID INT IDENTITY(1,1) PRIMARY KEY,
	carteraID INT NOT NULL,
	tipoID INT NOT NULL,
	monto DECIMAL(10,2) NOT NULL,
	fecha DATETIME NOT NULL,
	CONSTRAINT FK_tipo_transaccion
	FOREIGN KEY(tipoID)
		REFERENCES dbo.Transacciones_Tipos(tipoID)
);
GO