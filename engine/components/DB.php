
<?php
class DB {
    protected static $_instance;
    private function __construct() {
        
    }
    public static function getInstance() {
        if (self::$_instance === null) {
            $paramsPath = SITE_ROOT . 'config/db_config.php';
            $params = include ($paramsPath);
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
            self::$_instance = new PDO($dsn, $params['user'], $params['password']);
        }
        return self::$_instance;
    }
    private function __clone() {
        
    }
    private function __wakeup() {
        
    }
}