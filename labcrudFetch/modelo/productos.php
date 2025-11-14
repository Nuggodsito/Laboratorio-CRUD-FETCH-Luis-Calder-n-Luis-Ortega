<?php
require_once "conexion.php";

class Producto {
    private $db;
    public $controlError = [];
    
    // Propiedades
    public $id;
    public $codigo;
    public $producto;
    public $precio;
    public $cantidad;
    
    public function __construct() {
        $this->db = DB::getInstance();
    }
    
    public function setRequiredFields($fields) {
        foreach($fields as $field) {
            if(empty($_POST[$field])) {
                $this->controlError[$field] = "El campo $field es obligatorio";
            }
        }
    }
    
    public function validate() {
        // Validación adicional del precio
        if(isset($_POST['precio']) && !is_numeric($_POST['precio'])) {
            $this->controlError['precio'] = "El precio debe ser numérico";
        }
        
        // Validación adicional de cantidad
        if(isset($_POST['cantidad']) && !is_numeric($_POST['cantidad'])) {
            $this->controlError['cantidad'] = "La cantidad debe ser numérica";
        }
    }
    
    public function guardar() {
        $data = array(
            "codigo" => $this->codigo,
            "producto" => $this->producto,
            "precio" => $this->precio,
            "cantidad" => $this->cantidad
        );
        
        return $this->db->insertSeguro("productos", $data);
    }
    
    public function actualizarProducto() {
        $data = array(
            "codigo" => $this->codigo,
            "producto" => $this->producto,
            "precio" => $this->precio,
            "cantidad" => $this->cantidad
        );
        
        return $this->db->updateSeguro("productos", $data, "id = " . $this->id);
    }
    
    public function buscarProductos($termino = "") {
        if($termino == "") {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            return $this->db->query($sql);
        } else {
            $sql = "SELECT * FROM productos WHERE producto LIKE :termino OR codigo LIKE :termino OR precio LIKE :termino ORDER BY id DESC";
            return $this->db->query($sql, ['termino' => "%$termino%"]);
        }
    }
    
    public function obtenerProducto($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }
    
    public function eliminarProducto($id) {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function ModelsToNotes($postData) {
        $this->id = $postData['idp'] ?? '';
        $this->codigo = $postData['codigo'] ?? '';
        $this->producto = $postData['producto'] ?? '';
        $this->precio = $postData['precio'] ?? '';
        $this->cantidad = $postData['cantidad'] ?? '';
    }
}
?>