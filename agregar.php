<?php
// connect to database
include 'config/database.php';
session_start();

// product details
$id = isset($_GET['id']) ?  $_GET['id'] : die;
$name = isset($_GET['name']) ?  $_GET['name'] : die;
$quantity  = isset($_GET['quantity']) ?  $_GET['quantity'] : die;
$user_id=1;
$created=date('Y-m-d H:i:s');


$_SESSION["array"][] = array('id'=>$id,'nombre'=>$name,'cantidad'=>$quantity,'usuario'=>$user_id,'fecha'=>$created);


if(!empty($_SESSION["array"])){
    header('Location: menuProducto.php?action=added&id=' . $id . '&name=' . $name);
}
 
// if database insert failed
else{
     header('Location: productos.php?action=failed&id=' . $id . '&name=' . $name);
}
 