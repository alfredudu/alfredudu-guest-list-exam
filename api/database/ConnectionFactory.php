<?php
class ConnectionFactory {

    public static function getDB() {
        $connection = self::getConnection();
        $db = new NotORM($connection);
        return $db;
    }
    
    private static function getConnection() {
        $dbhost = getenv('IP');
        $dbuser = getenv('C9_USER');
        $dbpass = '';
        $dbname = 'c9';
        
        try {
            $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        }
        catch(Exception $e) {
           echo $e->getMessage();
           die;
        }
        
        return $connection;
    }
}
?>