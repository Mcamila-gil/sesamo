<?php
include("head.php");
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT pedidos.totalPago, pedidos.fecha, pedidos.idPedidos, GROUP_CONCAT(	productos.idProducto, '..',  productos.nombre, '..', cart_items.quantity SEPARATOR '__') AS productos FROM pedidos INNER JOIN cart_items ON cart_items.idPedidos = pedidos.idPedidos INNER JOIN productos ON productos.idProducto = cart_items.product_id GROUP BY pedidos.idPedidos ORDER BY pedidos.idPedidos;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12" style="background-color:#000000;color: #fff;">
		<h1>Pedidos</h1>
		<br>
		<table class="table table-bordered" style="background-color:#fff; color: #000;"> 
			<thead>
				<tr>
					<th>Número</th>
					<th>Fecha</th>
					<th>Productos</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($ventas as $venta){ ?>
				<tr>
					<td><?php echo $venta->idPedidos ?></td>
					<td><?php echo $venta->fecha ?></td>
					<td>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>Descripción</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody >
								<?php foreach(explode("__", $venta->productos) as $productosConcatenados){ 
								$producto = explode("..", $productosConcatenados)
								?>
								<tr>
									<td><?php echo $producto[0] ?></td>
									<td><?php echo $producto[1] ?></td>
									<td><?php echo $producto[2] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>
					<td><?php echo $venta->totalPago ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
