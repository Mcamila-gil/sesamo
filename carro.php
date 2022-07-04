<?php
include("head.php");
// connect to database
include 'config/database.php';
//Se inicia sesion para pasar datos entre paginas
session_start();
// Titulo de la pagina
$page_title="Carrito";
 
//Valores tomados para realizar las notificaciones
$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['nombre']) ? $_GET['nombre'] : "";?>

<h1>Carrito de compras</h1></br>

<?php 
//Notificaciones
if($action=='removed'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> fue eliminado del carrito!";
    echo "</div>";
}
 
else if($action=='quantity_updated'){
    echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> la cantidad ha sido actualizada!";
    echo "</div>";
}
 
else if($action=='failed'){
        echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> no se pudo actualizar la cantidad!";
    echo "</div>";
}
 
else if($action=='invalid_value'){
        echo "<div class='alert alert-info'>";
        echo "<strong>{$name}</strong> cantidad es inválida!";
    echo "</div>";
}
 
//Verificamos si el array de productos esta vacio
if(!empty($_SESSION['array'])){ 
    echo '<body style="background-color:#000000;color: #fff;">';
    echo "<table class='table table-hover table-responsive table-bordered' style='background-color:#fff; color: #000;'>";
    echo "<tr>";
        echo "<th class='textAlignLeft'>Nombre del producto</th>";
        echo "<th>Precio</th>";
            echo "<th style='width:15em;'>Cantidad</th>";
            echo "<th>Sub Total</th>";
            echo "<th>Acciones</th>";
    echo "</tr>";
    $total=0;

    //For para iterar en el array y mostrar lo que se agrego al carrito
    foreach ($_SESSION['array'] as $key => $value) {
        $id=$value['id'];
        //Consulta de precio segun el Id del producto 
        $query="SELECT precio FROM productos WHERE idProducto = $id";
        $stmt = $con->prepare( $query );
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        $precio= $resultado === false ? 1 : $resultado->precio;
       
        //Mostrar datos del array en la tabla
        echo "<tr>";
            echo "<td>";
                        echo "<div class='product-id' style='display:none;'>{$value['id']}</div>";
                        echo "<div class='product-name'>{$value['nombre']}</div>";
            echo "</td>";
            echo "<td>&#36;" . number_format($precio, 2, '.', ',') . "</td>";
            echo "<td>";
                        echo "<div class='input-group'>";
                            echo "<input type='number' name='quantity' value='{$value['cantidad']}' class='form-control'>";
                            echo "<input type='number' name='quantity' value='{$key}' style='display:none;'>";
                            echo "<span class='input-group-btn'>";
                                echo "<button class='btn btn-info update-quantity' type='button'><i class='glyphicon glyphicon-refresh'></i> Actualizar</button>";
                            echo "</span>";
                             
                        echo "</div>";
                echo "</td>";
                echo "<td>&#36;" . $subtotal = $value['cantidad']*$precio. "</td>";
                echo "<td>";
                echo "<a href='eliminar.php?id={$value['id']}&name={$value['nombre']}&key={$key}' class='btn btn-danger'>";
                echo "<span class='glyphicon glyphicon-remove'></span> Quitar del carrito";
                echo "</a>";
                echo "</td>";
                echo "</tr>";
             
            $total += $subtotal;
        }   

        echo "<tr>";
        echo "<td><b>Total</b></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td>&#36;" .$total. "</td>";
        echo "<td>";
        //Botón para terminar pedido y añadir datos a la BD
        echo "<div class='input-group'>";
        echo "<input name='total' type='hidden' value='{$total}'>
        <button type='submit' class='btn btn-success add-total'>Enviar pedido</button>&nbsp;
        <a href='cancelarPedido.php' class='btn btn-danger'>Cancelar pedido</a> </div>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        //Si el array esta vacio indicamos que no encontramos productos en el carrito
        }else{
            echo "<div class='alert alert-danger'>";
            echo "<strong>No se han encontrado productos</strong> en tu carrito!";
            echo "</div>";
        }
        
        include 'footer.php';
        echo '</body>';
?>
