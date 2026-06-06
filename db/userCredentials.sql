USE master
GO

CREATE LOGIN php_app_login
WITH PASSWORD = '1234567890',
	DEFAULT_DATABASE = KicksAndJerseys,
	CHECK_EXPIRATION = OFF,
	CHECK_POLICY = ON;

USE KicksAndJerseys
GO

CREATE USER php_app_user
FOR LOGIN php_app_login

GRANT EXECUTE ON SCHEMA::dbo TO php_app_user