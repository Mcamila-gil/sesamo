<?php

include_once "base_de_datos.php";
session_start();

$ahora = date("Y-m-d H:i:s");
$total =isset($_GET['total']) ?  $_GET['total'] : die;
$sentencia = $base_de_datos->prepare("INSERT INTO pedidos(fecha, totalPago) VALUES (?, ?);");
$sentencia->execute([$ahora, $total]);

$sentencia = $base_de_datos->prepare("SELECT idPedidos FROM pedidos ORDER BY idPedidos DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idPedidos= $resultado === false ? 1 : $resultado->idPedidos;

foreach ($_SESSION['array'] as $value) {				
    
    $id = $value['id'];
    $cantidad = $value['cantidad'];
    $usuario = $value['usuario'];
    $fecha = $value['fecha'];

    $sentencia = $base_de_datos->prepare("INSERT INTO cart_items(product_id, idPedidos, quantity, user_id, created) VALUES (?,?,?,?,?);");
    $sentencia->execute([$id,$idPedidos,$cantidad,$usuario,$fecha]); 
}

session_destroy();
header("Location: menuProducto.php?");
?>