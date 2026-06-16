<?php
class Database {
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection() : PDO {
        if (self::$instance === null) {
            $server = "DESKTOP-UUD5G95\SQLEXPRESS";
            $database = "KicksAndJerseys";
            $user = "php_app_login";
            $password = "1234567890";

            $dsn = "sqlsrv:Server=$server;Database=$database;";
            self::$instance = new PDO(
                $dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
                ]
            );
        }
        return self::$instance;
    }
}
?>