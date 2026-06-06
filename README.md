# Configuración

1. Se deben de ejecutar todos los archivos de \db antes de ejecutar la aplicación: DDL.sql, DML.sql y userCredentials.sql
	1. userCredentials será un usuario compartido para facilitar la compatibilidad entre equipos
2. En el archivo dentro de \model llamado connection.php se debe de cambiar la línea 9:
	1. $server = "<nombre_servidor>"
	2. El resto de líneas no se deben de cambiar
3. Para que SQL Server detecte el perfil compartido creado en userCredentials se deberá de:

Click derecho sobre el servidor y elegir propiedades.
[[!Paso1.png]]

Ir al apartado de Seguridad y seleccionar la opción de autenticación de Windows y SQL Server. Después dar click en Aceptar.
[[!Paso2.png]]

Finalmente dan click derecho sobre el servidor y pulsan reiniciar.
[[!Paso3.png]]

# Ejecución
Para ejecutar el servidor se debe de posicionar en la carpeta raíz del proyecto, luego, en la consola de comandos (cmd) se escribe el siguiente comando: 
php -S localhost:5000

Al acceder al enlace a través de un navegador les saldrá un error (es normal), para navegar a la vista de login deberán de poner en la URL:
http://localhost:5000/controller/authController.php

Alternativamente también pueden usar:
http://localhost:5000/view/loginRegister.php