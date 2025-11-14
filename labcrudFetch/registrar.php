<?php
header("Content-Type: application/json");

include("Modelo/conexion.php");
include("Modelo/Productos.php");

$myProducts = new Producto();
$myProducts->ModelsToNotes($_POST);

$Accion = $_POST['Accion'] ?? '';

switch ($Accion) {
    case "Guardar":
        $myProducts->setRequiredFields(['codigo', 'producto', 'precio', 'cantidad']);
        $myProducts->validate();

        if (empty($myProducts->controlError)) {
            $myProducts->guardar();
            $mensaje = "Producto Creado";
            $response = [ 
                "success" => true,
                "message" => $mensaje,
                "accion" => "Guardar"
            ];
        } else {
            $mensaje = "Producto no creado";
            $response = [ 
                "success" => false,
                "message" => $mensaje,
                "accion" => "Guardar",
                "errors" => $myProducts->controlError
            ];
        }
        echo json_encode($response);
        exit;
        break;

    case "Modificar":
        $myProducts->setRequiredFields(['codigo', 'producto', 'precio', 'cantidad']);
        $myProducts->validate();

        if (empty($myProducts->controlError)) {
            $myProducts->actualizarProducto();
            $mensaje = "Producto Actualizado";
            $response = [ 
                "success" => true,
                "message" => $mensaje,
                "accion" => "Modificar"
            ];
        } else {
            $mensaje = "El Producto no fue actualizado";
            $response = [ 
                "success" => false,
                "message" => $mensaje,
                "accion" => "Modificar",
                "errors" => $myProducts->controlError
            ];
        }
        echo json_encode($response);
        exit;
        break;

    case "Eliminar":
        $id = $_POST['id'] ?? '';
        if ($myProducts->eliminarProducto($id)) {
            $response = [ 
                "success" => true,
                "message" => "Producto Eliminado",
                "accion" => "Eliminar"
            ];
        } else {
            $response = [ 
                "success" => false,
                "message" => "Error al eliminar",
                "accion" => "Eliminar"
            ];
        }
        echo json_encode($response);
        exit;
        break;

    case "Listar":
        $busqueda = $_POST['busqueda'] ?? '';
        $productos = $myProducts->buscarProductos($busqueda);
        echo json_encode($productos);
        exit;
        break;

    case "Obtener":
        $id = $_POST['id'] ?? '';
        $producto = $myProducts->obtenerProducto($id);
        echo json_encode($producto);
        exit;
        break;

    default:
        $response = [ 
            "success" => false,
            "message" => "Acción no válida"
        ];
        echo json_encode($response);
        exit;
}
?>