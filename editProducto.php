<!-- Interfaz con formulario para implementar el requerimiento de editar/actualizar producto -->
    <?php
    include("conexion.php");
    //Include para evitar repetir codigo de interfaz
    include("head.php");
    ?>
    <body style="background-color:#000000;">
        <h1>Actualizar producto</h1>
        <hr>
        <!-- Conexion de formulario con la BD para agregar productos--> 
        <?php
        //If de captura de datos
            $nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
            $sql = mysqli_query($con, "SELECT * FROM productos WHERE idProducto='$nik'");
            
			if(mysqli_num_rows($sql) == 0){
				//header("Location: menuProducto.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['act'])){
                $nombre= mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres
                $descripcion = mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES)));//Escanpando caracteres 
                //$idTipo= mysqli_real_escape_string($con,(strip_tags($_POST["idTipo"],ENT_QUOTES)));//Escanpando caracteres
                $precio = mysqli_real_escape_string($con,(strip_tags($_POST["precio"],ENT_QUOTES)));//Escanpando caracteres

				$update =  mysqli_query($con, "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$descripcion' WHERE idProducto='$nik'") or die(mysqli_error());

				if($update){
					header("Location: editProducto.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
        ?>  
        
       <!-- Formulario-->
        <form method="post" enctype="multipart/form-data">
            <label>Nombre</label>	
            <input name="nombre" type="text" value="<?php echo $row ['nombre'];?>" placeholder="Nombre del producto" maxlength="30" pattern="[a-zA-Z0-9\s]+" required autofocus/>
            <label>Tipo</label>
            <select name="idTipo">
            <option value=""><?php echo $row ['idTipo'];?></option>
            <?php
            //Filtro para implementar opciones de tipo
                $query = $con -> query ("SELECT * FROM tipos");
                while ($valores = mysqli_fetch_array($query)) {
                    echo '<option value="'.$valores['idTipo'].'">'.$valores['categoria'].'</option>';
                }
             ?>
            </select>
            <label for="foto">Imagen del producto</label>
            <input style="color: white" type="file" name="foto" id="foto">
            <label>Precio</label>
            <input name="precio" type="number" value="<?php echo $row ['precio']; ?>" min="1" required>
            <label>Descripción</label>
            <textarea name="descripcion" value="" placeholder="Ej: Queso gratinado, salsa roja mexicana y frijoles" rows="6" required><?php echo $row ['descripcion'];?></textarea>
            <button href="menuProducto.php" type="submit" name='act'><i class="zmdi zmdi-floppy"></i> Modificar</button>
        </form>	 
    </body>
</html>
