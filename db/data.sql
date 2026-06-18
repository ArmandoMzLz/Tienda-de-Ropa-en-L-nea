USE KicksAndJerseys

--Datos base
INSERT INTO dbo.Usuarios_Roles(nombre) 
	VALUES ('Cliente'), ('Administrador');

INSERT INTO dbo.Productos_Categorias(nombre)
	VALUES ('Playeras Jerseys'), ('Tenis'), ('Tenis para Running'), ('Tenis Deportivos'), ('Tenis para Correr'), ('Pants Pantalon'), ('Hoodies Sudadera');

INSERT INTO dbo.Pedidos_Status(nombre)
	VALUES ('Pagado'), ('Enviado'), ('Entregado'), ('Cancelado');

INSERT INTO dbo.Transacciones_Tipos(nombre)
	VALUES ('Recarga'), ('Compra'), ('Devolución');

--Datos de muestra
SELECT * FROM dbo.Productos_Categorias;

INSERT INTO dbo.Productos (categoriaID, marca, nombre, precioBase, estaDisponible, imagenBaseURL) 
	VALUES (2, 'Adidas', 'Tenis Gamecourt 3 All Court', 1999.00, 1, '/images/products/tenis_Gamecourt3AllCourt.jpg'),
		   (2, 'Adidas', 'Tenis Courtjam Control 3', 2099.00, 1, '/images/products/tenis_CourtjamControl.jpg'),
		   (2, 'Adidas', 'Tenis SL 72 RS', 2299.00, 1, '/images/products/tenis_sl72rs.jpg'),
		   (2, 'Adidas', 'Tenis Samba OG', 2299.00, 1, '/images/products/tenis_SambaOg.jpg'),
		   (2, 'Nike', 'Tenis Free Metcon 7', 2999.00, 1, '/images/products/tenis_FreeMetcon7.jpg'),
		   (2, 'Nike', 'Tenis Bella 7', 2099.00, 1, '/images/products/tenis_Bella7.jpg')