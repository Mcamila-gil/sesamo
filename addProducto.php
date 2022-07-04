<!-- Interfaz con formulario para implementar el requerimiento de registrar/agregar producto -->
<?php
include("conexion.php");
//Include para evitar repetir codigo de interfaz
include("head.php");
?>
    <body style="background-color:#000000;">
        <h1>Agregar producto</h1>
        <hr>
        <!-- Conexion de formulario con la BD para agregar productos--> 
        <?php
        //If de captura de datos
        if(isset($_POST['insert'])){
            $nombre= mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
            $idTipo= mysqli_real_escape_string($con,(strip_tags($_POST["idTipo"],ENT_QUOTES)));//Escanpando caracteres
            $precio = mysqli_real_escape_string($con,(strip_tags($_POST["precio"],ENT_QUOTES)));//Escanpando caracteres 
            $descripcion = mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES)));//Escanpando caracteres 

            $cek = mysqli_query($con, "SELECT * FROM productos WHERE nombre='$nombre'");
            // if para verificar si el dato existe
            if(mysqli_num_rows($cek)>0)
            {
                echo '<div class="adv">Error. Producto existente!</div>';
            }else{ 
                //Variables para guardar la imagen del producto en carpeta y en base de datos
                $foto = $_FILES['foto'];
                $nombre_foto = $foto['name'];
                $type = $foto['type'];
                $url_temp = $foto['tmp_name'];
                
                $destino = 'imagen/';
                $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
                $imgProducto = $img_nombre.'.png';
                $src = $destino.$imgProducto;

                //if para insertar datos
                if(mysqli_num_rows($cek) == 0){
                    $insert = mysqli_query($con, "INSERT INTO productos(idProducto, nombre, idTipo, foto, precio, descripcion)
                    VALUES(NULL,'$nombre','$idTipo','$imgProducto','$precio','$descripcion')") or die(mysqli_error());
                   
                    //if para notificaciones
                    if($insert){
                        move_uploaded_file($url_temp, $src);
                        echo '<div class="correcto"></button> Bien hecho! Los datos han sido guardados con éxito.</div>';
                    }else{
                        echo '<div class="error">Error. No se pudo guardar los datos !</div>';
                    } 
                }
            }
        }
        
        ?>  
        <!-- Formulario-->
        <form method="post" enctype="multipart/form-data">
            <label>Nombre</label>	
            <input name="nombre" type="text" placeholder="Nombre del producto" maxlength="30" pattern="[a-zA-Z\s]+" required autofocus/>
            <label>Tipo</label>
            <select name="idTipo" required>
            <option value="">Seleccione:</option>
            <?php
            //Filtro para implementar opciones de tipo
                $query = $con -> query ("SELECT * FROM tipos");
                while ($valores = mysqli_fetch_array($query)) {
                    echo '<option value="'.$valores['idTipo'].'">'.$valores['categoria'].'</option>';
                }
             ?>
            </select>
            <label for="foto">Imagen del producto</label>
            <input style="color: white" type="file" name="foto" id="foto" required>
            <label>Precio</label>
            <input name="precio" type="number" min="1" required>
            <label>Descripción</label>
            <textarea name="descripcion" placeholder="Ej: Queso gratinado, salsa roja mexicana y frijoles" rows="6" required></textarea>
            <button name='insert' type="submit" >Enviar</button>
        </form>	 
    </body>
</html>
