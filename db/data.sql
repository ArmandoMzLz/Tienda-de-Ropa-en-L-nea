USE KicksAndJerseys

--Datos base
INSERT INTO dbo.Usuarios_Roles(nombre) 
	VALUES ('Cliente'), ('Administrador');

INSERT INTO dbo.Productos_Categorias(nombre)
	VALUES ('Playeras Jerseys'), ('Tenis'), ('Tenis Deportivos'), ('Tenis para Correr'), ('Pants Pantalon'), ('Hoodies Sudadera');

INSERT INTO dbo.Pedidos_Status(nombre)
	VALUES ('Pagado'), ('Enviado'), ('Entregado'), ('Cancelado');

INSERT INTO dbo.Transacciones_Tipos(nombre)
	VALUES ('Recarga'), ('Compra'), ('Devolución');

--Datos de muestra
INSERT INTO dbo.Productos (categoriaID, marca, nombre, precioBase, estaDisponible, imagenBaseURL) 
	VALUES (3, 'Adidas', 'Tenis Gamecourt 3 All Court', 1999.00, 1, '/images/products/tenis_Gamecourt3AllCourt.jpg'),
		   (3, 'Adidas', 'Tenis Courtjam Control 3', 2099.00, 1, '/images/products/tenis_CourtjamControl.jpg'),
		   (2, 'Adidas', 'Tenis SL 72 RS', 2299.00, 1, '/images/products/tenis_sl72rs.jpg'),
		   (2, 'Adidas', 'Tenis Samba OG', 2299.00, 1, '/images/products/tenis_SambaOg.jpg'),
		   (2, 'Nike', 'Tenis Free Metcon 7', 2999.00, 1, '/images/products/tenis_FreeMetcon7.jpg'),
		   (2, 'Nike', 'Tenis Bella 7', 2099.00, 1, '/images/products/tenis_Bella7.jpg'),
		   (2, 'Nike', 'Tenis Sabrina 3', 3199.00, 1, '/images/products/tenis_Sabrina3.jpg'),
		   (2, 'Nike', 'Tenis Book 2 Haven and Hector', 3599.00, 1, '/images/products/tenis_Book2HavenAndHector.jpg'),
		   (3, 'Nike', 'Tenis LeBron Witness 9', 2499.00, 1, '/images/products/tenis_LebronWitness9.jpg'),
		   (3, 'Nike', 'Tenis G.T. Cut 4 Jordan Poole', 4899.00, 1, '/images/products/tenis_GtCut4JordanPoole.jpg'),
		   (3, 'Nike', 'Tenis Kobe XI Elite Protro', 4499.00, 1, '/images/products/tenis_KobeXiEliteProtro.jpg'),
		   (4, 'Reebok', 'Tenis Floating 2 Solemates', 2899.00, 1, '/images/products/tenis_Floating2Solemates.jpg'),
		   (4, 'Reebok', 'Tenis Floatzig 2', 2899.00, 1, '/images/products/tenis_Floatzing2.jpg'),
		   (4, 'Reebok', 'Tenis Floatzig Double', 3099.00, 1, '/images/products/tenis_FloatzigDouble.jpg'),
		   (4, 'Reebok', 'Tenis Zig Dynamica 6', 1999.00, 1, '/images/products/ZigDynamica6.jpg'),
		   (2, 'Reebok', 'Tenis Nano Gym', 1999.00, 1, '/images/products/tenis_NanoGym.jpg'),
		   (4, 'Puma', 'Tenis Skyrocket Lite 2', 1399.00, 1, '/images/products/tenis_SkyrocketLite2.jpg'),
		   (2, 'Puma', 'Tenis Boulder', 2349.00, 1, '/images/products/tenis_Boulder.jpg'),
		   (4, 'Puma', 'Tenis Trail Running Fast-Trac Nitro 4', 2899.00, 1, '/images/products/tenis_TrailRunningFastTracNitro4.jpg'),
		   (2, 'Puma', 'Tenis Meza', 2049.00, 1, '/images/products/tenis_Meza.jpg'),
		   (4, 'Puma', 'Tenis Flyer Lite 3', 1449.00, 1, '/images/products/tenis_FlyerLite3.jpg'),
		   (4, 'Puma', 'Tenis Deviate Nitro', 4499.00, 1, '/images/products/tenis_DeviateNitro.jpg'),
		   (3, 'Jordan', 'Tenis Air Jordan 3 World Best', 4499.00, 1, '/images/products/tenis_AirJordan3WorldBest.jpg'),
		   (3, 'Jordan', 'Tenis Air Jordan 1 Mid SE', 3499.00, 1, '/images/products/tenis_AirJordan1MidSe.jpg'),
		   (3, 'Jordan', 'Tenis Air Jordan 1 Retro Low OG Banned', 3299.00, 1, '/images/products/tenis_AirJordan1RetroLowOgBanned.jpg'),
		   (3, 'Jordan', 'Tenis Jordan Sixty Plus Low', 3899.00, 1, '/images/products/tenis_JordanSixtyPlusLow.jpg'),
		   (4, 'Under Armour', 'Tenis Infinite', 2499.00, 1, '/images/products/tenis_UaInfinite.jpg'),
		   (4, 'Under Armour', 'Tenis Charged Assert 10', 1299.00, 1, '/images/products/tenis_ChargedAssert10.jpg'),
		   (4, 'Under Armour', 'Tenis Project Rock 7', 3799.00, 1, '/images/products/tenis_ProjectRock7.jpg'),
		   (4, 'Under Armour', 'Tenis Charged Bandit Trail 2', 2399.00, 1, '/images/products/tenis_ChargedBanditTrail2.jpg'),
		   (4, 'Under Armour', 'Tenis Flex', 2099.00, 1, '/images/products/tenis_Flex.jpg'),
		   (1, 'Adidas', 'Jersey Local Selección Nacional de México 26 (Jugador)', 2999.00, 1, '/images/products/jersey_LocalSeleccionMexico26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante Selección Nacional de México 26 Manga Larga (Fan)', 2299.00, 1, '/images/products/jersey_VisitanteSeleccionMexico26JFanMangaLarga.jpg'),
		   (1, 'Adidas', 'Jersey Local Selección Argentina 26 (Jugador)', 2999.00, 1, '/images/products/jersey_LocalSeleccionArgentina26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante Selección Argentina 26 (Jugador)', 2999.00, 1, '/images/products/jersey_VisitanteSeleccionArgentina26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Local Selección Colombia 26 (Jugador)', 2999.00, 1, '/images/products/jersey_LocalSeleccionColombia26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante Selección Colombia 26 (Jugador)', 2999.00, 1, '/images/products/jersey_VisitanteSeleccionColombia26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Local Alemania 26 (Jugador)', 2999.00, 1, '/images/products/jersey_LocalSeleccionAlemania26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante Alemania 26 (Jugador)', 2999.00, 1, '/images/products/jersey_VisitanteSeleccionAlemania26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Local España 26 (Jugador)',2999.00 , 1, '/images/products/jersey_LocalSeleccionEspana26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante España 26 (Jugador)', 2999.00, 1, '/images/products/jersey_VisitanteSeleccionEspana26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Local Italia 26 (Jugador)', 2999.00, 1, '/images/products/jersey_LocalSeleccionItalia26Jugador.jpg'),
		   (1, 'Adidas', 'Jersey Visitante Italia 26 (Jugador)', 2999.00, 1, '/images/products/jersey_VisitanteSeleccionItalia26Jugador.jpg');

INSERT INTO dbo.Productos_Variantes (productoID, talla, cantidad)
	VALUES (1, '22', 50), (1, '23', 50), (1, '24', 50), (1, '25', 50), (1, '26', 50), (1, '27', 50), (1, '28', 50), (1, '29', 50), (1, '30', 50),
		   (2, '22', 50), (2, '23', 50), (2, '24', 50), (2, '25', 50), (2, '26', 50), (2, '27', 50), (2, '28', 50), (2, '29', 50), (2, '30', 50),
		   (3, '22', 50), (3, '23', 50), (3, '24', 50), (3, '25', 50), (3, '26', 50), (3, '27', 50), (3, '28', 50), (3, '29', 50), (3, '30', 50),
		   (4, '22', 50), (4, '23', 50), (4, '24', 50), (4, '25', 50), (4, '26', 50), (4, '27', 50), (4, '28', 50), (4, '29', 50), (4, '30', 50),
		   (5, '22', 50), (5, '23', 50), (5, '24', 50), (5, '25', 50), (5, '26', 50), (5, '27', 50), (5, '28', 50), (5, '29', 50), (5, '30', 50),
		   (6, '22', 50), (6, '23', 50), (6, '24', 50), (6, '25', 50), (6, '26', 50), (6, '27', 50), (6, '28', 50), (6, '29', 50), (6, '30', 50),
		   (7, '22', 50), (7, '23', 50), (7, '24', 50), (7, '25', 50), (7, '26', 50), (7, '27', 50), (7, '28', 50), (7, '29', 50), (7, '30', 50),
		   (8, '22', 50), (8, '23', 50), (8, '24', 50), (8, '25', 50), (8, '26', 50), (8, '27', 50), (8, '28', 50), (8, '29', 50), (8, '30', 50),
		   (9, '22', 50), (9, '23', 50), (9, '24', 50), (9, '25', 50), (9, '26', 50), (9, '27', 50), (9, '28', 50), (9, '29', 50), (9, '30', 50),
		   (10, '22', 50), (10, '23', 50), (10, '24', 50), (10, '25', 50), (10, '26', 50), (10, '27', 50), (10, '28', 50), (10, '29', 50), (10, '30', 50),
		   (11, '22', 50), (11, '23', 50), (11, '24', 50), (11, '25', 50), (11, '26', 50), (11, '27', 50), (11, '28', 50), (11, '29', 50), (11, '30', 50),
		   (12, '22', 50), (12, '23', 50), (12, '24', 50), (12, '25', 50), (12, '26', 50), (12, '27', 50), (12, '28', 50), (12, '29', 50), (12, '30', 50),
		   (13, '22', 50), (13, '23', 50), (13, '24', 50), (13, '25', 50), (13, '26', 50), (13, '27', 50), (13, '28', 50), (13, '29', 50), (13, '30', 50),
		   (14, '22', 50), (14, '23', 50), (14, '24', 50), (14, '25', 50), (14, '26', 50), (14, '27', 50), (14, '28', 50), (14, '29', 50), (14, '30', 50),
		   (15, '22', 50), (15, '23', 50), (15, '24', 50), (15, '25', 50), (15, '26', 50), (15, '27', 50), (15, '28', 50), (15, '29', 50), (15, '30', 50),
		   (16, '22', 50), (16, '23', 50), (16, '24', 50), (16, '25', 50), (16, '26', 50), (16, '27', 50), (16, '28', 50), (16, '29', 50), (16, '30', 50),
		   (17, '22', 50), (17, '23', 50), (17, '24', 50), (17, '25', 50), (17, '26', 50), (17, '27', 50), (17, '28', 50), (17, '29', 50), (17, '30', 50),
		   (18, '22', 50), (18, '23', 50), (18, '24', 50), (18, '25', 50), (18, '26', 50), (18, '27', 50), (18, '28', 50), (18, '29', 50), (18, '30', 50),
		   (19, '22', 50), (19, '23', 50), (19, '24', 50), (19, '25', 50), (19, '26', 50), (19, '27', 50), (19, '28', 50), (19, '29', 50), (19, '30', 50),
		   (20, '22', 50), (20, '23', 50), (20, '24', 50), (20, '25', 50), (20, '26', 50), (20, '27', 50), (20, '28', 50), (20, '29', 50), (20, '30', 50),
		   (21, '22', 50), (21, '23', 50), (21, '24', 50), (21, '25', 50), (21, '26', 50), (21, '27', 50), (21, '28', 50), (21, '29', 50), (21, '30', 50),
		   (22, '22', 50), (22, '23', 50), (22, '24', 50), (22, '25', 50), (22, '26', 50), (22, '27', 50), (22, '28', 50), (22, '29', 50), (22, '30', 50),
		   (23, '22', 50), (23, '23', 50), (23, '24', 50), (23, '25', 50), (23, '26', 50), (23, '27', 50), (23, '28', 50), (23, '29', 50), (23, '30', 50),
		   (24, '22', 50), (24, '23', 50), (24, '24', 50), (24, '25', 50), (24, '26', 50), (24, '27', 50), (24, '28', 50), (24, '29', 50), (24, '30', 50),
		   (25, '22', 50), (25, '23', 50), (25, '24', 50), (25, '25', 50), (25, '26', 50), (25, '27', 50), (25, '28', 50), (25, '29', 50), (25, '30', 50),
		   (26, '22', 50), (26, '23', 50), (26, '24', 50), (26, '25', 50), (26, '26', 50), (26, '27', 50), (26, '28', 50), (26, '29', 50), (26, '30', 50),
		   (27, '22', 50), (27, '23', 50), (27, '24', 50), (27, '25', 50), (27, '26', 50), (27, '27', 50), (27, '28', 50), (27, '29', 50), (27, '30', 50),
		   (28, '22', 50), (28, '23', 50), (28, '24', 50), (28, '25', 50), (28, '26', 50), (28, '27', 50), (28, '28', 50), (28, '29', 50), (28, '30', 50),
		   (29, '22', 50), (29, '23', 50), (29, '24', 50), (29, '25', 50), (29, '26', 50), (29, '27', 50), (29, '28', 50), (29, '29', 50), (29, '30', 50),
		   (30, '22', 50), (30, '23', 50), (30, '24', 50), (30, '25', 50), (30, '26', 50), (30, '27', 50), (30, '28', 50), (30, '29', 50), (30, '30', 50),
		   (31, '22', 50), (31, '23', 50), (31, '24', 50), (31, '25', 50), (31, '26', 50), (31, '27', 50), (31, '28', 50), (31, '29', 50), (31, '30', 50),
		   (32, 'CH', 50), (32, 'M', 50), (32, 'G', 50), (32, 'XG', 50),
		   (33, 'CH', 50), (33, 'M', 50), (33, 'G', 50), (33, 'XG', 50),
		   (34, 'CH', 50), (34, 'M', 50), (34, 'G', 50), (34, 'XG', 50),
		   (35, 'CH', 50), (35, 'M', 50), (35, 'G', 50), (35, 'XG', 50),
		   (36, 'CH', 50), (36, 'M', 50), (36, 'G', 50), (36, 'XG', 50),
		   (37, 'CH', 50), (37, 'M', 50), (37, 'G', 50), (37, 'XG', 50),
		   (38, 'CH', 50), (38, 'M', 50), (38, 'G', 50), (38, 'XG', 50),
		   (39, 'CH', 50), (39, 'M', 50), (39, 'G', 50), (39, 'XG', 50),
		   (40, 'CH', 50), (40, 'M', 50), (40, 'G', 50), (40, 'XG', 50),
		   (41, 'CH', 50), (41, 'M', 50), (41, 'G', 50), (41, 'XG', 50),
		   (42, 'CH', 50), (42, 'M', 50), (42, 'G', 50), (42, 'XG', 50),
		   (43, 'CH', 50), (43, 'M', 50), (43, 'G', 50), (43, 'XG', 50);