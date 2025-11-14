<?php
class DB {
    private $pdo;
    private static $instance = null;
    
    public function __construct() {
        $servidor = "mysql:dbname=productosdb;host=localhost";
        $user = "root";
        $pass = "";
        
        try {
            $this->pdo = new PDO($servidor, $user, $pass, 
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    public function insertSeguro($tabla, $data) {
        $campos = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        
        $sql = "INSERT INTO $tabla ($campos) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateSeguro($tabla, $data, $where) {
        $set = "";
        foreach($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");
        
        $sql = "UPDATE $tabla SET $set WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function Arreglos($sql, $params = []) {
        return $this->query($sql, $params);
    }
}
?>