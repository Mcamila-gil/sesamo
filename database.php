<?php

class Database
{
    private static $dbHost = "localhost";
    private static $dbName = "sesamodatab";
    private static $dbUsername = "root";
    private static $dbUserpassword = "";
    
    private static $con = null;
    

    public static function connect()
    {
        if(self::$con == null)
        {
            try
            {
              self::$con= new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$con;
    }
    
    public static function disconnect()
    {
        self::$con = null;
    }

}
?>
