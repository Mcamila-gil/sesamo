<?php
// Conexion base de datos e inicio de sesion
include 'config/database.php';
session_start();

// Variables par actualizar
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
$quantity=intval($quantity);
$user_id=1;
$key = isset($_GET['key']) ? $_GET['key'] : "";

//Cantidad antes de ser actualizada
$cant1=$_SESSION['array'][$key]['cantidad'];

//Recorremos el array y hacemos la actualizacion en la llave especificada
foreach ($_SESSION['array'] as $key=> &$producto) { 
    $producto['cantidad'] = $quantity;
}

//Cantidad luego de actualizarla
$cant2=$_SESSION['array'][$key]['cantidad'];

//Veficamos si la cantidad ha cambiado y enviamos notificaciones
 if($cant1!=$cant2){
    //Redirecciona al usuario cuando el producto es actualizado
    header('Location: carro.php?action=quantity_updated&id=' . $id . '&name=' . $name);
}

else{
    //Redirecciona al usuario cuando falla la actualizacion
    header('Location: carro.php?action=failed&id=' . $id . '&name=' . $name);
} 
?>