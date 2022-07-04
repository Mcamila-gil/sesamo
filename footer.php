    </div>
    <!-- /container -->
 
<!-- jQuery library -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 
<!-- bootstrap JavaScript -->
<script src="libs/js/bootstrap.min.js"></script>
<script src="libs/js/holder.js"></script>
 
<script>
$(document).ready(function(){

    $('.add-to-cart').click(function(){
        var id = $(this).closest('div').find('.product-id').text();
        var name = $(this).closest('div').find('.product-name').text();
        var quantity = $(this).closest('div').find('input').val();
        window.location.href = "agregar.php?id=" + id + "&name=" + name + "&quantity=" + quantity;
    });
     
    $('.update-quantity').click(function(){
        var id = $(this).closest('tr').find('.product-id').text();
        var name = $(this).closest('tr').find('.product-name').text();
        var quantity = $(this).closest('tr').find('input').val();
        var key = $(this).closest('tr').find('input').val();
        window.location.href = "actualizar.php?id=" + id + "&name=" + name + "&quantity=" + quantity + "&key" + key;
    });

    $('.add-total').click(function(){
        var total = $(this).closest('div').find('input').val();
        window.location.href = "terminarPedido.php?total=" + total;
    });


});
</script>
 
</body>
</html>