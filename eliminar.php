<?php
//Conexion a la BD e inicio de sesion
include 'config/database.php';
session_start();

//Tamaño inicial del array
$tamaño1=count($_SESSION['array']);
// Obtener variables
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$key = isset($_GET['key']) ? $_GET['key'] : "";
$user_id=1;

//Funcion para eliminar un indice especifico
unset($_SESSION['array'][$key]);

//Tamaño luego de eliminar un indice
$tamaño2=count($_SESSION['array']);
 
//Verificamos que el ultimo tamaño sea menor al inicial y enviamos notificacion
if($tamaño1>$tamaño2){
    // redirect and tell the user product was removed
    header('Location: carro.php?action=removed&id=' . $id . '&name=' . $name);
}
 
// if remove failed
else{
    // redirect and tell the user it failed
    header('Location: carro.php?action=failed&id=' . $id . '&name=' . $name);
}  
?>