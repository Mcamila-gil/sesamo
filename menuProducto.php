<!-- Interfaz de menu para implementar el requerimiento de consultar/mostrar y eliminar producto -->
<?php 
include("conexion.php");
include 'config/database.php';
//Include para evitar repetir codigo de interfaz
include("head.php");
?>
    <head>
    <!--Librerias para realizar el contenedor de cada producto-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/styless.css">
    </head>

    <body style="background-color:#000000;">
        <h1>Menú Sésamo</h1>
        <hr>
        <div class="container site">
            <?php
                echo '<nav> <ul class="nav nav-pills">';
                require 'database.php';
               //Obetener datos para notificaciones
                $action = isset($_GET['action']) ? $_GET['action'] : "";
                $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
                $name = isset($_GET['nombre']) ? $_GET['nombre'] : "";
                $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "1";
                
                //Notificaciones de añadir a la cesta o de algun fallo
                if($action=='added'){
                    echo "<div class='alert alert-info'>";
                        echo "<strong>{$name}</strong> ¡agregado a tu carrito!";
                    echo "</div>";
                }
                
                else if($action=='failed'){
                    echo "<div class='alert alert-info'>";
                        echo "<strong>{$name}</strong> No se pudo agregar a su carrito!";
                    echo "</div>";
                }
                
                //Conexion a la base de datos y se consulta las categorias y se realiza sus respectivos botones
                $db = Database::connect();
                $statement = $db->query('SELECT * FROM tipos');
                $tipos = $statement->fetchAll();
                foreach ($tipos as $category) 
                {
                    if($category['idTipo'] == '1')
                        echo '<li role="presentation" class="active"><a href="#'. $category['idTipo'] . '" data-toggle="tab">' . $category['categoria'] . '</a></li>';
                    else
                        echo '<li role="presentation"><a href="#'. $category['idTipo'] . '" data-toggle="tab">' . $category['categoria'] . '</a></li>';
                }
                echo    '</ul>
                      </nav>';
                echo '<div class="tab-content">';
                //Se le asigna una referencia a cada categoria
                foreach ($tipos as $category) 
                {
                    if($category['idTipo'] == '1')
                        echo '<div class="tab-pane active" id="' . $category['idTipo'] .'">';
                    else
                        echo '<div class="tab-pane" id="' . $category['idTipo'] .'">';
                    
                    echo '<div class="row">';
                    
                    //Se toma la referencia de la categoria para filtar los datos y mostrarlos
                    $statement = $db->prepare('SELECT * FROM productos WHERE productos.idTipo = ?');
                    $statement->execute(array($category['idTipo']));
                    while ($producto = $statement->fetch(PDO::FETCH_ASSOC)) 
                    {   
                        echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail">';  
                                echo '<img src="imagen/' . $producto['foto'] . '" alt="...">
                                <div class="price">$' .$producto['precio']. '</div>
                                <div class="caption">
                                    <h4 class="product-name">'. $producto['nombre'] . '</h4>
                                    <h4 class="product-id" style="display:none;">'.$producto['idProducto']. '</h4>
                                    <p>' . $producto['descripcion'] . '</p>';
                                    $idprod = $producto['idProducto'];
                    
                                    /* //if($num>0){
                                        echo "<td>";
                                        echo "<input type='text' name='quantity' value='{$quantity}' disabled class='form-control' />";
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-success' disabled>";
                                        echo "<span class='glyphicon glyphicon-shopping-cart'></span> Agregado!$quantity";
                                        echo "</button>";
                                        echo "</td>";             
                                    }else{ */
                                        echo "<td>";
                                        echo "<input type='number' name='quantity' value='1' class='form-control' />";
                                        echo "</td>";
                                        
                                        echo "</table>";
                                   // }
                                   echo "<button class='btn btn-order add-to-cart' style='    margin-left: 1px;'>";
                                        echo "<span class='glyphicon glyphicon-shopping-cart'></span> Añadir a la cesta";
                                        echo "</button>";
                                    echo '
                                    <a href="editProducto.php?nik='.$producto['idProducto'].'" class="btn btn-order" style="margin-bottom: 10px;" role="button"> Modificar </a></li>
                                    <a href="menuProducto.php?aksi=delete&nik='.$producto['idProducto'].'" class="btn btn-order" role="button" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos?\)"> Eliminar</a>
                                    
                                </div>
                            </div>
                        </div>';
                       
                    }
                   echo    '</div>
                </div>';
            }
                echo  '</div>';

                //Comparacion de llave para eliminar datos
                
                if(isset($_GET['aksi']) == 'delete'){
					$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
					$cek = mysqli_query($con, "SELECT * FROM productos WHERE idProducto='$nik'");
					//Notificaciones y eliminar
                    if(mysqli_num_rows($cek) == 0){
                        echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
                
                    }else{
                        $delete = mysqli_query($con, "DELETE FROM productos WHERE idProducto='$nik'");
                        $delete = mysqli_query($con, "DELETE FROM productos WHERE idProducto='$nik'");
                    if($delete){
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminados correctamente.</div>';
                    
                    }	else{
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
                        } 
                    }
                    //Reinicia los datos enviados por href para evitar entrar en la notificacion de datos no encontrados
                    header("Location: menuProducto.php");
				}
                include 'footer.php';
            ?>
        </div>  
    </body>
</html>